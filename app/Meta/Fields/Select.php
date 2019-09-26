<?php

namespace App\Meta\Fields;

use App\Meta\Field;
use Illuminate\Validation\Rule;

class Select extends Field
{
    /**
     * @var array
     */
    protected $options;

    /**
     * @param string $key
     * @param string $title
     * @param array  $options
     * @param string $description
     */
    public function __construct(string $key, string $title, array $options, string $description = '')
    {
        $this->key = $key;
        $this->title = $title;
        $this->options = $options;
        $this->description = $description;
    }

    /**
     * {@inheritDoc}
     */
    public function getMeta(): array
    {
        return [
            'options' => collect($this->options)->map(function ($label, $value) {
                if (is_int($value)) {
                    $value = $label;
                }

                return [
                    'value' => $value,
                    'label' => $label,
                ];
            })->values(),
        ];
    }
}
