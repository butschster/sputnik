<?php

namespace App\Models\Server;

use App\Contracts\Server\Modules\Registry;
use App\Models\Concerns\HasServer;
use App\Models\Concerns\HasTask;
use App\Models\Concerns\UsesUuid;
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
     * @return \App\Contracts\Server\Module
     *
     * @throws \App\Exceptions\Server\ModuleNotFoundException
     */
    public function toModule(): \App\Contracts\Server\Module
    {
        return app(Registry::class)->get($this->name);
    }
}
