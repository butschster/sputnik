<?php

namespace Module\Supervisor\Scripts\Daemon;

use App\Models\Server\Record;
use Domain\SSH\Script;

class Restart extends Script
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
        return view('Supervisor::scripts.daemon.restart', [
            'id' => $this->record->id
        ]);
    }
}
