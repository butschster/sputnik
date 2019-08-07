<?php

namespace App\Contracts\Request;

use Carbon\Carbon;

interface RequestSignatureHandler
{
    /**
     * Create signature for given parameters
     *
     * @param array $parameters
     * @param Carbon|null $expiration
     *
     * @return array
     */
    public function signParameters(array $parameters = [], Carbon $expiration = null): array;

    /**
     * Validate signature
     *
     * @param string $signature
     * @param array $parameters
     * @param int|null $expires
     *
     * @return bool
     */
    public function validate(string $signature, array $parameters = [], int $expires = null): bool;
}
