<?php

namespace App\Server\Modules\Database;

use App\Contracts\Server\Modules\Configuration;
use App\Server\Module;

class MariaDB extends Module
{
    /**
     * Get module categories
     *
     * @return array
     */
    public function categories(): array
    {
        return ['database', 'sql'];
    }

    /**
     * Get module title
     * @return string
     */
    public function title(): string
    {
        return 'MariaDB';
    }

    /**
     * Get module key
     * @return string
     */
    public function key(): string
    {
        return 'mariadb';
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
