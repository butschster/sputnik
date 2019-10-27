<?php

namespace App\Models\User;

use App\Models\Concerns\UsesUuid;
use App\Models\User;
use Domain\SourceProvider\Contracts\SourceProvider as SourceProviderContract;
use Domain\SourceProvider\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SourceProvider extends Model
{
    use UsesUuid;

    /**
     * @var string
     */
    protected $table = 'user_source_providers';

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return SourceProviderContract
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function getClient(): SourceProviderContract
    {
        return app(Factory::class)->make($this);
    }
}
