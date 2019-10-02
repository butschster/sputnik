<?php

namespace App\Contracts\Server\Modules\Action;

interface HasFields
{
    /**
     * @return array
     */
    public function fields(): array;
}