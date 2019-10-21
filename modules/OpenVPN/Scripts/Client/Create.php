<?php

namespace Module\OpenVPN\Scripts\Client;

use App\Models\Server\Record;
use App\Utils\SSH\Script;

class Create extends Script
{
    /**
     * @var string
     */
    protected $name = 'Create OpenVPN client config';

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
        return view('OpenVPN::scripts.client.create', [
            'name' => $this->record->meta['name'],
            'protocol' => $this->record->module->meta['protocol'],
            'port' => $this->record->module->meta['port'],
            'configuration' => $this->record->server->toConfiguration(),
        ])->render();
    }
}
