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
    <div class="flex min-h-screen">
        <aside class="w-64 bg-blue-600 sidebar">
            @yield('sidebar')
        </aside>
        <div class="flex-1">
            <nav class="bg-white border-b mb-8 flex justify-between">
                <div class="flex-1">

                </div>

                <div class="py-4 px-6 flex">
                    <img src="https://api.adorable.io/avatars/161/abott@adorable.png" alt="" class="h-10 rounded-full">
                    <div class="text-sm ml-4">
                        <a href="{{ route('user.profile') }}">{{ Auth::user()->name }}</a>
                        <div class="text-xs text-gray-700">
                            {{ Auth::user()->email }}
                        </div>
                    </div>
                </div>
            </nav>

            <div class="container pt-12 px-12 m-auto">
                @yield('content')
            </div>
        </div>
    </div>
</div>
<script src="{{ mix('js/app.js') }}" defer></script>
</body>
</html>
