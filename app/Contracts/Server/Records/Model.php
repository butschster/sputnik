<?php

namespace App\Contracts\Server\Records;

use Illuminate\Contracts\Support\Arrayable;

interface Model extends Arrayable
{
    /**
     * Get module key
     *
     * @return string
     */
    public function module(): string;

    /**
     * Get model key
     *
     * @return string
     */
    public function key(): string;

    /**
     * @return string|null
     */
    public function feature(): ?string;

    /**
     * Get attributes to save
     *
     * @return array
     */
    public function getMetaAttributes();
}