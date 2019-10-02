<?php

namespace App\Contracts\Server\Modules\Action;

interface HasCallbacks
{
    /**
     * @return array
     */
    public function callbacks(): array;
}