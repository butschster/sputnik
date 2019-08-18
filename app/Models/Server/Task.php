<?php

namespace App\Models\Server;

use App\Events\Task\Finished;
use App\Events\Task\Running;
use App\Events\Task\Timeout;
use App\Models\Concerns\HasServer;
use App\Models\Concerns\Prunable;
use App\Models\Concerns\UsesUuid;
use App\Models\Server;
use App\Services\Task\Contracts\Task as TaskContract;
use App\Utils\SSH\Script;
use App\Utils\SSH\Shell\Response;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Collection;

class Task extends Model implements TaskContract
{
    use UsesUuid, HasServer, Cachable, Prunable;

    const STATUS_PENDING = 'pending';
    const STATUS_RUNNING = 'running';
    const STATUS_FINISHED = 'finished';
    const STATUS_TIMEOUT = 'timeout';

    protected static function boot()
    {
        static::creating(function ($task) {
            $task->status = static::STATUS_PENDING;
        });

        parent::boot();
    }

    /**
     * {@inheritdoc}
     */
    protected $table = 'server_tasks';

    /**
     * {@inheritdoc}
     */
    protected $guarded = [];

    /**
     * {@inheritdoc}
     */
    protected $hidden = [
        'options',
        'output',
        'script',
    ];

    /**
     * @return MorphTo
     */
    public function owner(): MorphTo
    {
        return $this->morphTo('owner');
    }

    /**
     * Get the value of the options array.
     *
     * @param string $value
     * @return array
     */
    public function getOptionsAttribute(string $value)
    {
        return unserialize($value);
    }

    /**
     * Set the value of the options array.
     *
     * @param array $value
     * @return array
     */
    public function setOptionsAttribute(array $value): void
    {
        $this->attributes['options'] = serialize($value);
    }

    /**
     * Determine if the task was successful.
     *
     * @return bool
     */
    public function isSuccessful(): bool
    {
        if (is_null($this->exit_code)) {
            return false;
        }

        return (int) $this->exit_code === 0;
    }

    /**
     * Mark the task as running.
     */
    public function markAsRunning(): void
    {
        $this->update([
            'status' => static::STATUS_RUNNING,
        ]);

        event(new Running($this));
    }

    /**
     * Determine if the task is pending.
     *
     * @return bool
     */
    public function isPending(): bool
    {
        return $this->status === static::STATUS_PENDING;
    }

    /**
     * Determine if the task is running.
     *
     * @return bool
     */
    public function isRunning(): bool
    {
        return $this->status === static::STATUS_RUNNING;
    }

    /**
     * Mark the task as timed out.
     *
     * @param string $output
     */
    public function markAsTimedOut(string $output = ''): void
    {
        $this->update([
            'exit_code' => 1,
            'status' => static::STATUS_TIMEOUT,
            'output' => $output,
        ]);

        event(
            new Timeout($this)
        );
    }

    /**
     * Determine if the task is timed out.
     *
     * @return bool
     */
    public function isTimedOut(): bool
    {
        return $this->status === static::STATUS_TIMEOUT;
    }

    /**
     * Mark the task as finished.
     *
     * @param int $exitCode
     * @param string $output
     */
    public function markAsFinished(int $exitCode = 0, string $output = ''): void
    {
        $this->update([
            'exit_code' => $exitCode,
            'status' => static::STATUS_FINISHED,
            'output' => $output,
        ]);

        event(
            new Finished($this)
        );
    }

    /**
     * Determine if the task is finished.
     *
     * @return bool
     */
    public function isFinished(): bool
    {
        return $this->status === static::STATUS_FINISHED;
    }

    /**
     * Get the remote working directory path for the task.
     *
     * @return string
     */
    public function path(): string
    {
        return $this->user === 'root'
            ? '/root/.sputnik'
            : '/home/sputnik/.sputnik';
    }

    /**
     * Get the remote path to the script.
     *
     * @return string
     */
    public function scriptFile(): string
    {
        return $this->path() . '/' . $this->id . '.sh';
    }

    /**
     * Get the remote path to the output.
     *
     * @return string
     */
    public function outputFile(): string
    {
        return $this->path() . '/' . $this->id . '.out';
    }

    /**
     * Update the model for the given SSH response.
     *
     * @param Response $response
     */
    public function saveResponse(Response $response): void
    {
        $this->update([
            'status' => $response->isTimedOut() ? static::STATUS_TIMEOUT : static::STATUS_FINISHED,
            'exit_code' => $response->getExitCode(),
            'output' => $response->getOutput(),
        ]);

        event(
            new \App\Events\Task\Response($this, $response)
        );
    }

    /**
     * Get the task script
     *
     * @return string
     */
    public function script(): string
    {
        return $this->script;
    }

    /**
     * Get the task user
     *
     * @return string
     */
    public function user(): string
    {
        return $this->user;
    }

    /**
     * Get the maximum execution time for the task.
     *
     * @return int
     */
    public function timeout(): int
    {
        return (int) ($this->options['timeout'] ?? Script::DEFAULT_TIMEOUT);
    }

    /**
     * Get the task options
     *
     * @return array
     */
    public function options(): array
    {
        return $this->options;
    }

    /**
     * Get callbacks for the task
     *
     * @return \Illuminate\Support\Collection
     */
    public function callbacks(): Collection
    {
        $callbacks = $this->options['then'] ?? [];

        return collect($callbacks);
    }

    /**
     * Add new callback for the task
     *
     * @param string|Object $callback
     *
     * @return $this
     */
    public function addCallback($callback)
    {
        $callbacks = $this->callbacks()->add($callback);

        $options = $this->options;
        $options['then'] = $callbacks->all();

        $this->options = $options;

        $this->save();

        return $this;
    }

    /**
     * Get the server IP address
     *
     * @return string
     */
    public function serverIpAddress(): string
    {
        return $this->server->ip;
    }

    /**
     * Get the server SSH port
     *
     * @return int
     */
    public function serverPort(): int
    {
        return $this->server->ssh_port;
    }

    /**
     * Get the path to the server owner's worker SSH key.
     *
     * @return string
     */
    public function serverKeyPath(): string
    {
        return $this->server->privateKey()->getPath();
    }

    /**
     * Check if task's output is empty
     *
     * @return bool
     */
    public function outputIsEmpty(): bool
    {
        return $this->output  === '';
    }

    /**
     * Check if task's output is equal with given string
     *
     * @param string $string
     *
     * @return bool
     */
    public function outputIsEqual(string $string): bool
    {
        return $this->output == $string;
    }
}
