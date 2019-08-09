<?php

namespace App\Models\Server;

use App\Models\Concerns\HasServer;
use App\Models\Concerns\HasTask;
use App\Models\Concerns\UsesUuid;
use Illuminate\Database\Eloquent\Model;

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
    protected $guarded = [];

    /**
     * @var array
     */
    protected $casts = [
        'aliases' => 'array',
        'environment' => 'array',
    ];

    /**
     * @return string
     */
    public function repositoryBranch(): string
    {
        return $this->repository_branch ?? 'master';
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
            'site_id' => $this->id, 'action' => 'hook'
        ]));
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
