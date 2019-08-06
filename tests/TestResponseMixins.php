<?php

namespace Tests;

use Illuminate\Foundation\Testing\Assert as PHPUnit;

class TestResponseMixins
{
    public function assertCreated()
    {
        return function () {
            $actual = $this->getStatusCode();

            PHPUnit::assertTrue(
                201 === $actual,
                'Response status code ['.$actual.'] is not an created status code.'
            );

            return $this;
        };
    }
}
