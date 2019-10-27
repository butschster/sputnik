<?php

namespace Domain\Server\Services;

use App\Models\Server;
use App\Scripts\Server\Callbacks\MarkAsConfigured;
use App\Scripts\Server\Configure;
use App\Scripts\Utils\GetAptLockStatus;
use App\Scripts\Utils\GetCurrentDirectory;
use App\Services\Server\Runnable;
use Domain\Server\Exceptions\ConfigurationException;

class ConfiguratorService
{
    use Runnable;

    /**
     * Run the server configuration
     *
     * @param Server $server
     *
     * @return \Domain\Task\Contracts\Task
     * @throws \Throwable
     */
    public function configure(Server $server)
    {
        $this->setServer($server);
        $this->setOwner($server);

        if (!$this->server->isPending()) {
            throw new ConfigurationException(
                "Server [{$server->id}] can not be configured twice"
            );
        }

        $this->server->markAsConfiguring();

        return $this->runInBackground(
            new Configure($server),
            [
                'then' => [
                    MarkAsConfigured::class,
                ],
            ]
        );
    }

    /**
     * Determine if the server is ready for configuring.
     *
     * @param Server $server
     * @return bool
     */
    public function isServerReadyForConfigure(Server $server): bool
    {
        $this->setServer($server);
        $this->setOwner($server);

        // Check if remote user is root
        $canAccess = $this->run(new GetCurrentDirectory())->outputIsEqual('/root');

        if ($canAccess) {
            $apt = $this->run(new GetAptLockStatus());

            return $apt->isSuccessful() && $apt->outputIsEmpty();
        }

        return false;
    }
}
