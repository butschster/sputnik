<?php

namespace App\Models;

use App\Models\Concerns\UsesUuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Script extends Model
{
    use UsesUuid;

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'public' => 'bool',
        'multiple_execution' => 'bool',
        'meta' => 'array',
    ];

    /**
     * {@inheritdoc}
     */
    protected $guarded = [];

    /**
     * Get script owner
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get servers on which script was executed
     *
     * @return BelongsToMany
     */
    public function servers(): BelongsToMany
    {
        return $this->belongsToMany(Server::class);
    }

    /**
     * Check if script can be executed on specified server
     *
     * @param Server $server
     *
     * @return bool
     */
    public function canBeRunOnServer(Server $server): bool
    {
        if ($this->multiple_execution) {
            return true;
        }

        return !$this->servers()->where('server_id', $server->id)->exists();
    }

    /**
     * @param Builder $builder
     *
     * @return Builder
     */
    public function scopeOnlyPublic(Builder $builder)
    {
        return $builder->where('public', true);
    }
}
