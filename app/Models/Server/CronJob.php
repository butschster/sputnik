<?php

namespace App\Models\Server;

use App\Models\Concerns\UsesUuid;
use App\Models\Server;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CronJob extends Model
{
    use UsesUuid;

    /**
     * @var string
     */
    protected $table = 'server_jobs';

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @var array
     */
    protected $attributes = [
        'user' => 'root'
    ];

    /**
     * Link to the server
     *
     * @return BelongsTo
     */
    public function server(): BelongsTo
    {
        return $this->belongsTo(Server::class);
    }

    /**
     * Get the job name for crontab
     *
     * @return string
     */
    public function crontabName(): string
    {
        return "# Sputnik json " . $this->id;
    }

    /**
     * Get the logs path for job output
     *
     * @return string
     */
    public function logsPath(): string
    {
        return '/home/sputnik/.sputnik/scheduled-' . $this->id . '.log';
    }
}
