<?php

namespace App\Models\Server\Site;

use App\Events\Server\Site\Deployment\Failed;
use App\Events\Server\Site\Deployment\Finished;
use App\Events\Server\Site\Deployment\Running;
use App\Models\Concerns\DeterminesAge;
use App\Models\Concerns\HasTask;
use App\Models\Concerns\UsesUuid;
use App\Models\Server\Site;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Deployment extends Model
{
    use UsesUuid, HasTask, DeterminesAge;

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
     * @var string
     */
    protected $table = 'server_site_deployments';

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * Link to the site
     *
     * @return BelongsTo
     */
    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class, 'server_site_id');
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
     * Determine if the deployment is finished.
     *
     * @return bool
     */
    public function isFailed(): bool
    {
        return $this->status === static::STATUS_FAILED;
    }
}
