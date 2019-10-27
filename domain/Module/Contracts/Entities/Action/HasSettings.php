<?php

namespace Domain\Module\Contracts\Entities\Action;

interface HasSettings
{
    /**
     * @return array
     */
    public function settings(): array;
}