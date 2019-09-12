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
    <div id="app" class="min-w-full min-h-screen">
        <div class="min-h-screen pt-4 md:pr-10 min-w-full max-w-5xl">
            <a href="#" class="logo block mb-6 mx-auto"><img src="img/core-img/logo.png" alt="Logo"></a>
            <div class="flex mb-4 align-center">
                <div class="w-full md:w-1/2">
                    <img src="img/bg-img/maintenence.jpg" alt="Image">
                </div>
                <div class="w-full md:w-1/2">
                    <h2 class="mb-4">We are unable for 30 minutes. sorry for the inconvenience.</h2>
                    <p class="mb-5">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Explicabo exercitationem, consequatur quidem voluptatum repellat!</p>
                    <a href="#" class="btn btn-primary">Check Updates</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
