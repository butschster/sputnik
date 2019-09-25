<?php

namespace App\Models\Server;

use App\Contracts\Server\Modules\Repository;
use App\Models\Concerns\HasServer;
use App\Models\Concerns\HasTask;
use App\Models\Concerns\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use UsesUuid, HasServer, HasTask;

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

    /**
     * @return \App\Contracts\Server\Module
     *
     * @throws \App\Exceptions\Server\ModuleNotFoundException
     */
    public function toModule(): \App\Contracts\Server\Module
    {
        return app(Repository::class)->get($this->name);
    }
}