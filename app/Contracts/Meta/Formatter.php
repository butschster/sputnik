<?php

namespace App\Contracts\Meta;

interface Formatter
{

    /**
     * Format the given data
     *
     * @param string $key
     * @param array $data
     *
     * @return mixed
     */
    public function format(string $key, array $data);
}
