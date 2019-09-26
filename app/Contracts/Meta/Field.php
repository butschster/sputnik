<?php

namespace App\Contracts\Meta;

use Illuminate\Contracts\Support\Arrayable;

interface Field extends Arrayable
{
    /**
     * Get gield title
     *
     * @return string
     */
    public function getTitle(): string;

    /**
     * Get filed description
     *
     * @return string
     */
    public function getDescription(): string;

    /**
     * Get field key
     *
     * @return string
     */
    public function getKey(): string;

    /**
     * Get filed additional information
     *
     * @return array
     */
    public function getMeta(): array;

    /**
     * Get formatter
     *
     * @return Formatter
     */
    public function getFormatter(): Formatter;

    /**
     * Get validation rules
     *
     * @return array
     */
    public function getValidationRules(): array;

    /**
     * @param mixed $value
     *
     * @return mixed
     */
    public function prepareValue($value);
}
