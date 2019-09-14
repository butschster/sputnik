<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <div class="min-h-screen py-16 md:py-20 min-w-full flex flex-col justify-start">
            <a href="#" class="w-full inline-block"><img src="img/logo.png" class="mx-auto" alt="Logo"></a>
            <div class="py-12 flex-grow flex justify-between items-center">
                <div class="container mx-auto px-4">
                    <div class="flex items-center flex-wrap">
                        <div class="w-full md:w-1/2 pr-0 md:pr-4 mb-10 md:mb-0">
                            <img src="img/maintenence.jpg" alt="Image" class="max-w-2xl w-full mx-auto">
                        </div>
                        <div class="w-full md:w-1/2 pl-0 md:pl-4 mb-10 md:mb-0">
                            <h2 class="mb-4 text-4xl font-bold">We are unable for 30 minutes. Sorry for the inconvenience.</h2>
                            <p class="mb-8">We couldn't find any results for your search. Try again.</p>
                            <router-link class="btn btn-primary" :to="$link.servers()">
                                Check Updates
                            </router-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
