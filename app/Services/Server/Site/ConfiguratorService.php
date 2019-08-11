<?php

namespace App\Services\Server\Site;

use App\Models\Server\Site;
use App\Scripts\Server\Site\Create;
use App\Scripts\Server\Site\Delete;
use App\Services\Server\Runnable;
use App\Services\Task\Contracts\Task;

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

        return $this->runJob(new Create($site));
    }

    /**
     * @param Site $site
     * @return Task
     */
    public function delete(Site $site): Task
    {
        $this->setServer($site->server);
        $this->setOwner($site);

        return $this->runJob(new Delete($site));
    }
}
