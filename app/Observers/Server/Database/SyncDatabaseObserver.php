<?php

namespace App\Observers\Server\Database;

use App\Models\Server\Database;
use App\Services\Server\DatabaseService;

class SyncDatabaseObserver
{
    /**
     * @var DatabaseService
     */
    protected $service;

    /**
     * @param DatabaseService $service
     */
    public function __construct(DatabaseService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Database $database
     */
    public function created(Database $database): void
    {
        $this->service->create($database);
    }

    /**
     * @param Database $database
     */
    public function deleted(Database $database): void
    {
        $this->service->delete($database);
    }
}
