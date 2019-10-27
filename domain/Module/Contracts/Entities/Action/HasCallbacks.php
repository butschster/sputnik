<?php

namespace Domain\Module\Contracts\Entities\Action;

interface HasCallbacks
{
    /**
     * @return array
     */
    public function callbacks(): array;
}