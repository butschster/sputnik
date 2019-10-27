<?php

namespace Domain\Record\Contracts\Entities\Record;

use App\Models\Server\Record;

interface Factory
{
    /**
     * @param string $module
     *
     * @return Record
     */
    public function create(string $module): Record;
}