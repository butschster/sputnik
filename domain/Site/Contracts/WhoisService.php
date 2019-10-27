<?php

namespace Domain\Site\Contracts;

use App\Models\Server\Site;
use Domain\Site\Entities\Domain\DomainInformation;

interface WhoisService
{
    /**
     * Getting information about site domain
     *
     * @param Site $site
     * @return DomainInformation
     * @throws \Iodev\Whois\Exceptions\ConnectionException
     * @throws \Iodev\Whois\Exceptions\ServerMismatchException
     * @throws \Iodev\Whois\Exceptions\WhoisException
     */
    public function lookup(Site $site): DomainInformation;
}