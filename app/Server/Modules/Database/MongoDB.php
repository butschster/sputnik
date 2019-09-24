<?php

namespace App\Server\Modules\Database;

use App\Server\Module;
use App\Contracts\Server\Modules\Configuration;

class MongoDB extends Module
{
    /**
     * Get module categories
     *
     * @return array
     */
    public function categories(): array
    {
        return ['database', 'nosql'];
    }

    /**
     * Get module title
     * @return string
     */
    public function title(): string
    {
        return 'MongoDB';
    }

    /**
     * Get module key
     * @return string
     */
    public function key(): string
    {
        return 'mongodb';
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
