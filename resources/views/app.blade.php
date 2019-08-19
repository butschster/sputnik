<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{ config('app.name') }}</title>
    <link href="{{  mix("css/app.css") }}" rel="stylesheet" type="text/css">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <router-view></router-view>
    <script type="text/javascript" src="{{ mix("js/app.js" )}}"></script>
</body>
</html>
