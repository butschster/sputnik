<?php

namespace App\Contracts\Server\Modules\Action;

use App\Meta\FieldsCollection;

interface HasForm
{
    /**
     * @return FieldsCollection
     */
    public function getFields(): FieldsCollection;
}