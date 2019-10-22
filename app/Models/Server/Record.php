<?php

namespace App\Models\Server;

use App\Models\Concerns\HasServer;
use App\Models\Concerns\HasTask;
use App\Models\Concerns\UsesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Record extends Model
{
    use UsesUuid, HasServer, HasTask;

    /**
     * {@inheritdoc}
     */
    protected $table = 'server_records';

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'meta' => 'array',
        'model' => 'string',
    ];

    /**
     * {@inheritdoc}
     */
    protected $guarded = [];

    /**
     * @return BelongsTo
     */
    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }

    /**
     * Get record model instance
     *
     * @return \App\Contracts\Server\Records\Model
     */
    public function meta(): \App\Contracts\Server\Records\Model
    {
        $model = $this->model;

        return new $model($this->meta);
    }
}