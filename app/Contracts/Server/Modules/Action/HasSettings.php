<?php

namespace App\Contracts\Server\Modules\Action;

interface HasSettings
{
    /**
     * @return array
     */
    public function settings(): array;
}