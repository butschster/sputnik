<?php

namespace Domain\Site\Contracts\Entities;

interface Processor
{
    /**
     * Get processor key
     *
     * @return string
     */
    public function key(): string;

    /**
     * Get processor name
     *
     * @return string
     */
    public function name(): string;
}