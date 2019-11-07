<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-151758540-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', '{{ config('services.google_analytics.id') }}');
    </script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app" class="min-w-full min-h-screen">
    <div class="flex min-h-screen">
        <aside class="sidebar">

            <div class="sidebar-section">
                <h5>Manage</h5>
                <div class="nav">
                    <a class="nav-link" href="{{ route('home') }}">
                        Servers
                    </a>
                    <a class="nav-link" href="#">
                        Sites
                    </a>
                </div>
            </div>

            @yield('sidebar')

            <div class="sidebar-section">
                <h5>Account</h5>
                <div class="nav">
                    <a class="nav-link" href="{{ route('user.profile') }}">
                        Profile
                    </a>
                    <a class="nav-link" href="#">
                        Security
                    </a>
                    <a class="nav-link" href="#">
                        Projects
                    </a>
                    <a class="nav-link" href="#">
                        Referrals
                    </a>
                </div>
            </div>
        </aside>
        <div class="flex-1">
            <nav class="navbar">
                <div class="flex-1">

                </div>

                <div class="navbar__profile dropdown">
                    <img src="https://api.adorable.io/avatars/161/abott@adorable.png" alt="" class="navbar__profile--avatar">

                    <div class="dropdown-menu">
                        <div class="user-info px-6 py-2">
                            <img src="https://api.adorable.io/avatars/161/abott@adorable.png" alt="" class="user-info--avatar">
                            <div class="user-info--name">
                                <a href="{{ route('user.profile') }}">{{ Auth::user()->name }}</a>
                                <div class="user-info--email">
                                    {{ Auth::user()->email }}
                                </div>
                            </div>
                        </div>
                        <div class="dropdown-divider"></div>
                        <a href="" class="dropdown-link">Teams</a>
                        <a href="" class="dropdown-link">Account</a>
                        <a href="" class="dropdown-link">Sign out</a>
                    </div>
                </div>
            </nav>

            <div class="container pt-10 px-12 m-auto">
                @yield('content')
            </div>
        </div>
    </div>
</div>
<script src="{{ mix('js/app.js') }}" defer></script>
</body>
</html>
