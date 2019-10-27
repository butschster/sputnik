<?php

namespace Module\OpenVPN\Scripts\Client;

use App\Models\Server\Record;
use Domain\SSH\Script;

class Delete extends Script
{
    /**
     * @var string
     */
    protected $name = 'Delete OpenVPN client config';

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
        return view('OpenVPN::scripts.client.delete', [
            'name' => $this->record->meta['name'],
        ])->render();
    }
}
