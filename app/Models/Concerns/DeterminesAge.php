<?php

namespace App\Models\Concerns;

use Carbon\Carbon;

trait DeterminesAge
{
    /**
     * Determine if the model is older than N minutes.
     *
     * @param int|Carbon $minutes
     * @param string $attribute
     * @return bool
     */
    public function olderThan($minutes, $attribute = 'created_at'): bool
    {
        if (!$this->{$attribute}) {
            return false;
        }

        if (!$minutes instanceof Carbon) {
            $minutes = now()->subMinutes($minutes);
        }

        return $this->{$attribute}->lte($minutes);
    }
}
