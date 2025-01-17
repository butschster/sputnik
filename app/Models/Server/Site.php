<?php

namespace App\Models\Server;

use App\Models\Concerns\HasServer;
use App\Models\Concerns\HasTask;
use App\Models\Concerns\UsesUuid;
use App\Models\User\SourceProvider;
use Domain\SourceProvider\Validation\Rules\RepositoryName;
use Domain\SourceProvider\Validation\Rules\RepositoryUrl;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Laravel\Scout\Searchable;

class Site extends Model
{
    use UsesUuid, HasTask, HasServer, Searchable;

    /**
     * {@inheritdoc}
     */
    protected $table = 'server_sites';

    /**
     * {@inheritdoc}
     */
    protected $guarded = ['token'];

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'aliases' => 'array',
        'environment' => 'array',
        'domain_expires_at' => 'date',
        'use_ssl' => 'bool',
        'is_proxy' => 'bool',
        'ssl_certificate_expires_at' => 'date',
    ];

    /**
     * Get owner
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    /**
     * Get web server module
     *
     * @return BelongsTo
     */
    public function webServer(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Server\Module::class, 'webserver_id');
    }

    /**
     * Get processor module
     *
     * @return BelongsTo
     */
    public function processor(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Server\Module::class, 'processor_id');
    }

    /**
     * @param Builder $builder
     * @return Builder
     */
    public function scopeWithMonitoring(Builder $builder)
    {
        return $builder->whereHas('server', function ($q) {
            return $q->withMonitoring()->configured();
        });
    }

    /**
     * Check if repository is valid
     *
     * @return bool
     */
    public function isValidRepository(): bool
    {
        if ($this->isCustomRepository()) {
            return true;
        }

        return $this->isSourceProviderRepository();
    }

    /**
     * Check if repository owns to source provider (Github, Bitbucket, ....)
     *
     * @return bool
     */
    public function isSourceProviderRepository(): bool
    {
        return (new RepositoryName())->passes('', $this->repository) && $this->sourceProvider;
    }

    /**
     * @return bool
     */
    public function isCustomRepository(): bool
    {
        return (new RepositoryUrl())->passes('', $this->repository);
    }

    /**
     * @return bool
     */
    public function hasEnvironmentVariables(): bool
    {
        return !empty($this->environment);
    }

    /**
     * Get the deployments that belong to the site.
     *
     * @return MorphMany
     */
    public function deployments(): MorphMany
    {
        return $this->morphMany(Deployment::class, 'owner')->latest();
    }

    /**
     * @return bool
     */
    public function hasRunningDeployment(): bool
    {
        return $this->deployments()
            ->whereIn('status', [Deployment::STATUS_RUNNING, Deployment::STATUS_PENDING])
            ->exists();
    }

    /**
     * Get site repository source provider
     *
     * @return BelongsTo
     */
    public function sourceProvider(): BelongsTo
    {
        return $this->belongsTo(SourceProvider::class, 'repository_provider', 'type')
            ->where('user_id', $this->server()->first()->user_id ?? null);
    }

    /**
     * Get repository branch name
     *
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
        if ($this->isCustomRepository()) {
            return $this->repository;
        }

        if ($this->isSourceProviderRepository()) {
            return $this->sourceProvider
                ->getClient()
                ->cloneUrl($this->repository);
        }

        throw new \InvalidArgumentException('Repository URL not exists');
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

    /**
     * @return string
     */
    public function sslCertPath(): string
    {
        return '/etc/letsencrypt/live/' . $this->domain . '/server.pem';
    }

    /**
     * @return string
     */
    public function sslKeyPath(): string
    {
        return '/etc/letsencrypt/live/' . $this->domain . '/server.key';
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'server_id' => $this->server_id,
            'user_id' => $this->user_id,
            'domain' => $this->domain,
            'aliases' => $this->aliases,
            'repository' => $this->repository,
            'token' => $this->token,
        ];
    }
}
