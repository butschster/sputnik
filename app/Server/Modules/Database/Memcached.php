<?php

namespace App\Server\Modules\Database;

use App\Contracts\Server\Modules\Configuration;
use App\Server\Module;

class Memcached extends Module
{
    /**
     * Get module categories
     *
     * @return array
     */
    public function categories(): array
    {
        return ['database', 'nosql', 'cache'];
    }

    /**
     * Get module title
     * @return string
     */
    public function title(): string
    {
        return 'Memcached server';
    }

    /**
     * Get module key
     * @return string
     */
    public function key(): string
    {
        return 'memcached';
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
