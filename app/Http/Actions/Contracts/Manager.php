<?php

namespace App\Http\Actions\Contracts;

interface Manager
{
    /**
     * @param string $action
     * @param array $attributes
     *
     * @return mixed
     */
    public function runAction(string $action, array $attributes = []);
}
