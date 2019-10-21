<?php

namespace Module\OpenVPN\Scripts\Client;

use App\Models\Server\Record;
use App\Utils\SSH\Script;

class GetConfig extends Script
{
    /**
     * @var string
     */
    protected $name = 'Get OpenVPN client config';

    /**
     * @var Record
     */
    protected $record;

    /**
     * @param Record $record
     */
    public function __construct(Record $record)
    {
        $this->record = $record;
    }

    /**
     * Get the contents of the script.
     *
     * @return string
     */
    public function getScript(): string
    {
        return sprintf('cat ~/%s.ovpn', $this->record->meta['name']);
    }
}
