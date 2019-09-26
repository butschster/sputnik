<?php

namespace App\Meta\Fields;

use App\Meta\Field;

class Checkbox extends Field
{
    /**
     * @param string $key
     * @param string $title
     * @param string $description
     */
    public function __construct(string $key, string $title, string $description = '')
    {
        parent::__construct($key, $title, $description);

        $this->addValidationRule('boolean');
    }

    /**
     * {@inheritDoc}
     */
    public function prepareValue($value)
    {
        $acceptable = ['yes', 'on', '1', 1, true, 'true'];

        if (in_array($value, $acceptable, true)) {
            return true;
        }

        return false;
    }
}
