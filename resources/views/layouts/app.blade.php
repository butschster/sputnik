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
        <aside class="sidebar">
            @yield('sidebar')

            <div class="sidebar-section">
                <h5>Manage</h5>
                <div class="nav">
                    <a class="nav-link" href="{{ route('user.profile') }}">
                        Servers
                    </a>
                    <a class="nav-link" href="#">
                        Sites
                    </a>
                </div>
            </div>

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

            <div class="container pt-8 px-12 m-auto">
                @yield('content')
            </div>
        </div>
    </div>
</div>
<script src="{{ mix('js/app.js') }}" defer></script>
</body>
</html>
