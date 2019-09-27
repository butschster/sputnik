<?php

namespace App\Server\Modules\Database;

use App\Server\Module;
use App\Contracts\Server\Modules\Configuration;

class Redis extends Module
{
    /**
     * Get module categories
     *
     * @return array
     */
    public function categories(): array
    {
        return ['database', 'nosql', 'queue'];
    }

    /**
     * Get module type
     *
     * @return string
     */
    public function type(): string
    {
        return 'database.nosql';
    }

    /**
     * Get module title
     * @return string
     */
    public function title(): string
    {
        return 'Redis server';
    }

    /**
     * Get module key
     * @return string
     */
    public function key(): string
    {
        return 'redis';
    }

    /**
     * Get module configuration
     * @return Configuration
     */
    public function configuration(): Configuration
    {
        return new \App\Server\Modules\Database\Configuration($this);
    }
}
