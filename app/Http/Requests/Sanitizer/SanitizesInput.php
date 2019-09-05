<?php

namespace App\Http\Requests\Sanitizer;

use App\Contracts\Http\Request\Sanitizer\Factory as FactoryContract;

trait SanitizesInput
{
    /**
     * Sanitize input before validating.
     * Kept for backwards compatibility with Laravel <= 5.5
     * @return void
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @deprecated Renamed to validateResolved() in Laravel 5.6
     */
    public function validate()
    {
        $this->sanitize();

        parent::validate();
    }

    /**
     * Sanitize input before validating.
     * Compatible with Laravel 5.6+
     * @return void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function validateResolved()
    {
        $this->sanitize();

        parent::validateResolved();
    }

    /**
     * Filters to be applied to the input.
     * @return array
     */
    public function filters()
    {
        return [];
    }

    /**
     * Sanitize this request's input
     *
     * @return void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    private function sanitize(): void
    {
        $sanitizer = app(FactoryContract::class)
            ->make($this->input(), $this->filters());

        $this->replace($sanitizer->sanitize());
    }
}
