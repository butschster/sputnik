<?php

namespace Domain\Record\Events;

use App\Models\Server\Record;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Deleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Record
     */
    public $record;

    /**
     * @param Record $record
     */
    public function __construct(Record $record)
    {
        $this->record = $record;
    }
}