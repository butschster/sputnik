<?php

namespace App\Jobs\Server\Site;

use App\Contracts\Server\Site\WhoisService;
use App\Models\Server\Site;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class LookupDomain implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;

    /**
     * @var Site
     */
    protected $site;

    /**
     * @param Site $site
     */
    public function __construct(Site $site)
    {
        $this->site = $site;
    }

    /**
     * @param WhoisService $service
     * @throws \Iodev\Whois\Exceptions\ConnectionException
     * @throws \Iodev\Whois\Exceptions\ServerMismatchException
     * @throws \Iodev\Whois\Exceptions\WhoisException
     */
    public function handle(WhoisService $service): void
    {
        try {
            $info = $service->lookup($this->site);

            $this->site->update([
                'domain_expires_at' => $info->getExpirationDate(),
            ]);
        } catch (\Iodev\Whois\Exceptions\ServerMismatchException $e) {
            $this->fail($e);
        } catch (\Iodev\Whois\Exceptions\WhoisException $e) {
            $this->fail($e);
        }
    }

    /**
     * Handle a job failure.
     *
     * @param Exception $exception
     * @return void
     */
    public function failed(Exception $exception)
    {
        $this->site->server->alerts()->create([
            'type' => 'server.site.lookup.failed',
            'exception' => (string) $exception,
            'meta' => [
                'site_id' => $this->site->id
            ]
        ]);
    }
}
