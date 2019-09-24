<?php

namespace App\Server\Modules\PHP;

class PHP59 extends Module
{
    /**
     * Get module categories
     *
     * @return array
     */
    public function categories(): array
    {
        return ['php'];
    }

    /**
     * @return string
     */
    public function version(): string
    {
        return 59;
    }
}
