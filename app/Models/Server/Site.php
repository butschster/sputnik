<?php

namespace App\Models\Server;

use App\Models\Concerns\HasServer;
use App\Models\Concerns\HasTask;
use App\Models\Concerns\UsesUuid;
use App\Models\Server\Site\Deployment;
use App\Models\User\SourceProvider;
use App\Services\SourceProviders\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Site extends Model
{
    use UsesUuid, HasTask, HasServer;

    /**
     * @var string
     */
    protected $table = 'server_sites';

    /**
     * @var array
     */
    protected $guarded = ['token'];

    /**
     * @var array
     */
    protected $casts = [
        'aliases' => 'array',
        'environment' => 'array',
    ];

    /**
     * Get the deployments that belong to the site.
     *
     * @return HasMany
     */
    public function deployments(): HasMany
    {
        return $this->hasMany(Deployment::class, 'server_site_id')->latest();
    }

    /**
     * Get site repository source provider
     *
     * @return BelongsTo
     */
    public function sourceProvider(): BelongsTo
    {
        return $this->belongsTo(SourceProvider::class, 'repository_provider', 'type')
            ->where('user_id', $this->server->user_id);
    }

    /**
     * @return string
     */
    public function repositoryBranch(): string
    {
        return $this->repository_branch ?? 'master';
    }

    /**
     * Get clone url
     *
     * @return string
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function cloneUrl(): string
    {
        return app(Factory::class)
            ->make($this->sourceProvider)
            ->cloneUrl($this->repository);
    }

    /**
     * Get unique signed for this site URL for receiving events
     * from GitHib, Bitbucket, ...
     *
     * @return string
     */
    public function hooksHandlerUrl(): string
    {
        $urlSigner = app(\App\Contracts\Request\RequestSignatureHandler::class);

        return route('callback', $urlSigner->signParameters([
                'action' => 'hook',
            ]) + ['token' => $this->token, 'site_id' => $this->id,]);
    }

    /**
     * @return string
     */
    public function url(): string
    {
        return 'http://' . $this->domain;
    }

    /**
     * @return string
     */
    public function secureUrl(): string
    {
        return 'https://' . $this->domain;
    }

    /**
     * Get project folder path
     *
     * @return string
     */
    public function path(): string
    {
        return '/var/www/' . $this->domain;
    }

    /**
     * Get project public folder path
     *
     * @return string
     */
    public function publicPath(): string
    {
        return '/var/www/' . $this->domain . '/current/' . ltrim($this->public_dir, '/ ');
    }
}
