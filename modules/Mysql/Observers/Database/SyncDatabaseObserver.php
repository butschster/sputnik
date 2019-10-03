<?php

namespace Module\Mysql\Observers\Database;

use Module\Mysql\DatabaseService;
use Module\Mysql\Models\Database;

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
