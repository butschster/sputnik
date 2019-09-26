<?php

namespace App\Meta\Fields\Formatter;

use App\Contracts\Meta\Formatter;

class Text implements Formatter
{

    /**
     * {@inheritDoc}
     */
    public function format(string $key, array $data)
    {
        return $data[$key] ?: null;
    }
}
