<?php

namespace App\Meta;

use App\Contracts\Meta\Field as FieldContract;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class FieldsCollection extends Collection
{
    /**
     * The items contained in the collection.
     * @var array|FieldContract[]
     */
    protected $items = [];

    /**
     * Format
     *
     * @param array $data
     * @param string $prefix
     *
     * @return array
     */
    public function format(array $data, string $prefix = ''): array
    {
        $data = Arr::only($data, $this->keys()->map(function ($key) use ($prefix) {
            return $prefix . $key;
        }));

        $this->each(function (FieldContract $field) use (& $data, $prefix) {
            $key = $prefix . $field->getKey();

            if (isset($data[$key])) {
                $data[$key] = $field->getFormatter()->format($key, $data);
            }
        });

        return $data;
    }

    /**
     * Get fields keys
     * @return Collection
     */
    public function keys(): Collection
    {
        return $this->map(function (FieldContract $field) {
            return $field->getKey();
        });
    }

    /**
     * Get fields validation rules
     *
     * @param string $prefix
     *
     * @return array
     */
    public function getValidationRules(string $prefix = ''): array
    {
        $rules = [];

        foreach ($this->items as $field) {
            $rules[$prefix . $field->getKey()] = $field->getValidationRules();
        }

        return $rules;
    }

    /**
     * Get validation messages
     *
     * @param string $prefix
     *
     * @return array
     */
    public function getValidationMessages(string $prefix = ''): array
    {
        return [];
    }

    /**
     * Get validation labels
     *
     * @param string $prefix
     *
     * @return array
     */
    public function getValidationLabels(string $prefix = ''): array
    {
        $labels = [];

        foreach ($this->items as $field) {
            $labels[$prefix . $field->getKey()] = $field->getTitle();
        }

        return $labels;
    }
}
