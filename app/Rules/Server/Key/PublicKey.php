<?php

namespace App\Rules\Server\Key;

use Illuminate\Contracts\Validation\Rule;

class PublicKey implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $key = new \App\Utils\SSH\ValueObjects\PublicKey('key', $value);

        try {
            $fingerprint = $key->getFingerprint();

            return !empty($fingerprint);
        } catch (\Exception $e) {}

        return false;
    }

    /**
     * Get the validation error message.
     * TODO translate this message
     *
     * @return string
     */
    public function message()
    {
        return 'The public key should be valid';
    }
}
