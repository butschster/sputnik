<?php

namespace App\Services\Server\Site;

use App\Models\Server\Site;
use App\Services\Server\Site\Whois\DomainInformation;
use Iodev\Whois\Whois;

class WhoisService implements \App\Contracts\Server\Site\WhoisService
{
    /**
     * @var Whois
     */
    protected $whois;

    /**
     * @param Whois $whois
     */
    public function __construct(Whois $whois)
    {
        $this->whois = $whois;
    }

    /**
     * Getting information about site domain
     *
     * @param Site $site
     * @return DomainInformation
     * @throws \Iodev\Whois\Exceptions\ConnectionException
     * @throws \Iodev\Whois\Exceptions\ServerMismatchException
     * @throws \Iodev\Whois\Exceptions\WhoisException
     */
    public function lookup(Site $site): DomainInformation
    {
        return new DomainInformation(
            $this->whois->loadDomainInfo($site->domain)
        );
    }
}