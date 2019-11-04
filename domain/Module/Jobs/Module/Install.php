<?php

namespace Domain\Module\Jobs\Module;

use Domain\Module\Contracts\Entities\Module\Repository;
use App\Models\Server;
use Domain\Module\Exceptions\ModuleInstallationException;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Log;

class Install implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 1;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 300;

    /**
     * @var Server
     */
    public $server;

    /**
     * @var string
     */
    public $module;

    /**
     * @var array
     */
    public $data;

    /**
     * @param Server $server
     * @param string $module
     * @param array $data
     */
    public function __construct(Server $server, string $module, array $data = [])
    {
        $this->server = $server;
        $this->module = $module;
        $this->data = $data;
    }

    /**
     * @param Repository $repository
     *
     * @throws \Domain\Module\Exceptions\ModuleNotFoundException
     */
    public function handle(Repository $repository)
    {
        Log::debug('Install module', [
            'module' => $this->module
        ]);

        $module = $this->getModule();

        try {
            $repository->runAction($module->name, 'install', $this->server, $this->data);
        } catch (Exception $e) {
            $module->markAsFailed();

            $this->failed(ModuleInstallationException::for($module));
            $this->delete();
        }
    }

    /**
     * Handle a job failure.
     *
     * @param ModuleInstallationException $exception
     * @return void
     */
    public function failed(ModuleInstallationException $exception)
    {
        $this->server->alerts()->create([
            'type' => 'server.install.failed',
            'exception' => (string) $exception,
        ]);
    }

    /**
     * @return Server\Module
     */
    protected function getModule(): Server\Module
    {
        if (!$this->server->hasModule($this->module)) {
            $module = $this->server->modules()->create([
                'name' => $this->module,
                'meta' => $this->data,
            ]);

            $module->markAsInstalling();

            return $module;
        }

        return $this->server->getModule($this->module);
    }
}
