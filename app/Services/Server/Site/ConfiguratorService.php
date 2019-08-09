<?php

namespace App\Services\Server\Site;

use App\Models\Server\Site;
use App\Scripts\Server\Site\Create;
use App\Scripts\Server\Site\Delete;
use App\Services\Server\Runnable;

class ConfiguratorService
{
    use Runnable;

    /**
     * @param Site $site
     */
    public function create(Site $site)
    {
        $this->setServer($site->server);
        $this->setOwner($site);

        $this->runJob(new Create($site));
    }

    /**
     * @param Site $site
     */
    public function delete(Site $site)
    {
        $this->setServer($site->server);
        $this->setOwner($site);

        $this->runJob(new Delete($site));
    }
}
