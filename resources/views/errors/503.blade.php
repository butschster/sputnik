<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Service Unavailable') }}</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    <div class="min-h-screen py-16 md:py-20 min-w-full flex flex-col justify-start">
        <a href="#" class="w-full inline-block">
            <img src="{{ asset('img/logo.png') }}" class="mx-auto" alt="Logo">
        </a>
        <div class="py-12 flex-grow flex justify-between items-center">
            <div class="container mx-auto px-4">
                <div class="flex items-center flex-wrap">
                    <div class="w-full md:w-1/2 pr-0 md:pr-4 mb-10 md:mb-0">
                        <img src="{{ asset('img/maintenence.jpg') }}" alt="Image" class="max-w-2xl w-full mx-auto">
                    </div>
                    <div class="w-full md:w-1/2 pl-0 md:pl-4 mb-10 md:mb-0">
                        <h2 class="mb-4 text-4xl font-bold">
                            {{ __($exception->getMessage() ?: 'Service Unavailable') }}
                        </h2>
                        <p class="mb-8 text-lg text-gray-600">
                            @if($exception->willBeAvailableAt)
                            We are unable for {{ $exception->willBeAvailableAt->longAbsoluteDiffForHumans() }}.
                            @endif
                            Sorry for the inconvenience.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
