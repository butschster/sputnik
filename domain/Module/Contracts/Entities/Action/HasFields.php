<?php

namespace Domain\Module\Contracts\Entities\Action;

interface HasFields
{
    /**
     * @return array
     */
    public function fields(): array;
}
