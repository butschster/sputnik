<?php

namespace App\Models\Server;

use App\Models\Concerns\HasServer;
use App\Models\Concerns\HasTask;
use App\Models\Concerns\UsesUuid;
use App\Services\Server\CronService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class CronJob extends Model
{
    use UsesUuid, HasTask, HasServer;

    /**
     * {@inheritdoc}
     */
    protected $table = 'server_jobs';

    /**
     * {@inheritdoc}
     */
    protected $guarded = [];

    /**
     * {@inheritdoc}
     */
    protected $attributes = [
        'user' => 'root'
    ];

    /**
     * @param string $expression
     */
    public function setCronAttribute(string $expression): void
    {
        $this->attributes['cron'] = app(CronService::class)->parseExpression($expression);
    }

    /**
     * Get calculated cron job next run date
     *
     * @return Carbon
     */
    public function nextRunDate(): Carbon
    {
        return app(CronService::class)->nextRunDate($this->cron);
    }

    /**
     * Get the job name for crontab
     *
     * @return string
     */
    public function crontabName(): string
    {
        return "# Sputnik " . $this->id;
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
