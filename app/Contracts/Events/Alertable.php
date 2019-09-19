<?php

namespace App\Contracts\Events;

interface Alertable
{
    /**
     * Create an alert for the given instance.
     *
     * @return array
     */
    public function toAlert(): array;
}