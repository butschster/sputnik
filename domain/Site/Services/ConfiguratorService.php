<?php

namespace Domain\Site\Services;

use App\Models\Server\Site;
use App\Services\Server\Runnable;
use Domain\Task\Contracts\Task;

class ConfiguratorService
{
    use Runnable;

    /**
     * @param Site $site
     * @return Task
     */
    public function create(Site $site): Task
    {
        $this->setServer($site->server);
        $this->setOwner($site);

        $script = site_configurator()->createConfiguration(
            $site->webServer->name,
            optional($site->processor)->name,
            \Domain\Site\ValueObjects\Site::fromModel($site)
        );

        return $this->runJob($script);
    }

    /**
     * @param Site $site
     * @return Task
     */
    public function delete(Site $site): Task
    {
        $this->setServer($site->server);
        $this->setOwner($site);

        $script = site_configurator()->deleteConfiguration(
            $site->webServer->name,
            optional($site->processor)->name,
            \Domain\Site\ValueObjects\Site::fromModel($site)
        );

        return $this->runJob($script);
    }
}
