<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{ config('app.name') }}</title>
    <link href="{{  mix("css/app.css") }}" rel="stylesheet" type="text/css">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        window.user = @json($user)
    </script>
</head>
<body>
@csrf
<div id="app">
    <router-view></router-view>
    <portal-target name="modals"></portal-target>
</div>
<script src="https://js.stripe.com/v3/"></script>
<script type="text/javascript" src="{{ mix("js/app.js" )}}"></script>
</body>
</html>
