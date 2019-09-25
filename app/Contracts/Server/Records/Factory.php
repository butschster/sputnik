<?php

namespace App\Contracts\Server\Records;

interface Factory
{
    /**
     * @param string $module
     *
     * @return Record
     */
    public function create(string $module): Record;
}