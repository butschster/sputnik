<?php

namespace App\Models\Server;

use Domain\Module\Contracts\Registry;
use App\Models\Concerns\HasServer;
use App\Models\Concerns\HasTask;
use App\Models\Concerns\UsesUuid;
use Domain\Module\Events\Module\StatusChanged;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use UsesUuid, HasServer, HasTask;

    const STATUS_PENDING = 'pending';
    const STATUS_FAILED = 'failed';
    const STATUS_INSTALLING = 'installing';
    const STATUS_INSTALLED = 'installed';

    /**
     * {@inheritdoc}
     */
    protected $table = 'server_modules';

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'meta' => 'array',
    ];

    /**
     * {@inheritdoc}
     */
    protected $guarded = [];

    protected static function boot()
    {
        static::creating(function ($server) {
            $server->status = static::STATUS_PENDING;
        });

        parent::boot();
    }

    /**
     * Check if module belongs to categories
     *
     * @param array $categories
     * @return bool
     */
    public function belongsToCategories(array $categories): bool
    {
        return collect($this->toModule()->categories())->intersect($categories)->count() === count($categories);
    }

    /**
     * @return \Domain\Module\Contracts\Entities\Module
     *
     * @throws \Domain\Module\Exceptions\ModuleNotFoundException
     */
    public function toModule(): \Domain\Module\Contracts\Entities\Module
    {
        return app(Registry::class)->get($this->name);
    }

    /**
     * Mark the server as configured.
     */
    public function markAsInstalling(): void
    {
        $this->update(['status' => static::STATUS_INSTALLING]);

        event(new StatusChanged($this));
    }

    /**
     * Mark the server as configured.
     */
    public function markAsInstalled(): void
    {
        $this->update(['status' => static::STATUS_INSTALLED]);

        event(new StatusChanged($this));
    }

    /**
     * Mark the server as configured.
     */
    public function markAsFailed(): void
    {
        $this->update(['status' => static::STATUS_FAILED]);

        event(new StatusChanged($this));
    }
}
