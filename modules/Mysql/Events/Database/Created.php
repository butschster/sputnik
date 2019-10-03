<?php

namespace Module\Mysql\Events\Database;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Module\Mysql\Models\Database;

class Created
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Database
     */
    public $database;

    /**
     * @param Database $database
     */
    public function __construct(Database $database)
    {
        $this->database = $database;
    }
}