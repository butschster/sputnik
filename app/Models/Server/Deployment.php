<?php

namespace App\Models\Server;

use App\Events\Server\Deployment\Failed;
use App\Events\Server\Deployment\Finished;
use App\Events\Server\Deployment\Running;
use App\Events\Server\Deployment\Timeout;
use App\Models\Concerns\DeterminesAge;
use App\Models\Concerns\HasServer;
use App\Models\Concerns\HasTask;
use App\Models\Concerns\UsesUuid;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Deployment extends Model
{
    use UsesUuid, HasTask, HasServer, DeterminesAge;

    const STATUS_PENDING = 'pending';
    const STATUS_RUNNING = 'running';
    const STATUS_FINISHED = 'finished';
    const STATUS_FAILED = 'failed';
    const STATUS_TIMEOUT = 'timeout';

    protected static function boot()
    {
        static::creating(function ($deployment) {
            $deployment->status = static::STATUS_PENDING;
        });

        parent::boot();
    }

    /**
     * {@inheritdoc}
     */
    protected $table = 'server_deployments';

    /**
     * {@inheritdoc}
     */
    protected $guarded = [];

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'path' => 'string',
        'environment' => 'array',
    ];

    /**
     * Link to the owner model
     *
     * @return BelongsTo
     */
    public function owner(): BelongsTo
    {
        return $this->morphTo('owner');
    }

    /**
     * Link to the initiator user
     *
     * @return BelongsTo
     */
    public function initiator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Determine if the deployment is pending.
     *
     * @return bool
     */
    public function isPending(): bool
    {
        return $this->status === static::STATUS_PENDING;
    }

    /**
     * Mark the deployment as running.
     */
    public function markAsRunning(): void
    {
        $this->update([
            'status' => static::STATUS_RUNNING,
        ]);

        event(new Running($this));
    }

    /**
     * Determine if the deployment is running.
     *
     * @return bool
     */
    public function isRunning(): bool
    {
        return $this->status === static::STATUS_RUNNING;
    }

    /**
     * Mark the deployment as finished.
     */
    public function markAsFinished(): void
    {
        $this->update([
            'status' => static::STATUS_FINISHED,
        ]);

        event(
            new Finished($this)
        );
    }

    /**
     * Determine if the deployment is finished.
     *
     * @return bool
     */
    public function isFinished(): bool
    {
        return $this->status === static::STATUS_FINISHED;
    }

    /**
     * Mark the deployment as finished.
     */
    public function markAsFailed(): void
    {
        $this->update([
            'status' => static::STATUS_FAILED,
        ]);

        event(
            new Failed($this)
        );
    }

    /**
     * Mark the deployment as finished.
     */
    public function markAsTimedOut(): void
    {
        $this->update([
            'status' => static::STATUS_TIMEOUT,
        ]);

        event(
            new Timeout($this)
        );
    }

    /**
     * Determine if the deployment is finished.
     *
     * @return bool
     */
    public function isFailed(): bool
    {
        return $this->status === static::STATUS_FAILED;
    }

    /**
     * Check if deployment has been failed or finished
     *
     * @return bool
     */
    public function hasEnded(): bool
    {
        return $this->isFinished() || $this->isFailed();
    }
}
