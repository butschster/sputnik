<?php

namespace App\Server\Modules\Database;

use App\Server\Module;
use App\Contracts\Server\Modules\Configuration;

class MySQL8 extends Module
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
        return 'MySQL 8';
    }

    /**
     * Get module key
     * @return string
     */
    public function key(): string
    {
        return 'mysql8';
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
