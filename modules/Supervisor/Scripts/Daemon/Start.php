<?php

namespace Module\Supervisor\Scripts\Daemon;

use App\Models\Server\Record;
use App\Utils\SSH\Script;

class Start extends Script
{
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
        return view('Supervisor::scripts.daemon.start', [
            'id' => $this->record->id,
            'command' => $this->record->meta['command'],
            'user' => $this->record->meta['user'],
            'processes' => $this->record->meta['processes']
        ]);
    }
}
