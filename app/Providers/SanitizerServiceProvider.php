<?php

namespace App\Providers;

use App\Contracts\Http\Request\Sanitizer\Factory as FactoryContract;
use App\Http\Requests\Formatters;
use App\Http\Requests\Sanitizer\Factory;
use Illuminate\Support\ServiceProvider;

class SanitizerServiceProvider extends ServiceProvider
{
    /**
     * @var array
     */
    protected $filters = [
        'capitalize' => Formatters\Capitalize::class,
        'escape' => Formatters\EscapeHTML::class,
        'lowercase' => Formatters\Lowercase::class,
        'uppercase' => Formatters\Uppercase::class,
        'trim' => Formatters\Trim::class,
        'strip_tags' => Formatters\StripTags::class,
        'digit' => Formatters\Digit::class,
        'cron' => Formatters\CronFormatter::class,
        'remove_new_lines' => Formatters\RemoveNewLines::class,
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(FactoryContract::class, function () {
            return new Factory($this->filters);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

    }
}
