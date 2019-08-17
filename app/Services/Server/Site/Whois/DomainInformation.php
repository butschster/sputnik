<?php

namespace App\Services\Server\Site\Whois;

use Carbon\Carbon;
use Iodev\Whois\Modules\Tld\DomainInfo;

class DomainInformation
{
    /**
     * @var DomainInfo
     */
    protected $info;

    /**
     * @param DomainInfo $info
     */
    public function __construct(DomainInfo $info)
    {
        $this->info = $info;
    }

    /**
     * @return Carbon
     */
    public function getExpirationDate(): Carbon
    {
        return Carbon::createFromTimestamp($this->info->getExpirationDate());
    }

    /**
     * @return string
     */
    public function getOwner(): string
    {
        return $this->info->getOwner();
    }
}