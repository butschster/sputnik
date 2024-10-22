<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,700,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {background-image: linear-gradient(45deg, #389fff, #06213c);font-family: 'Montserrat', sans-serif;}
        h1 {font-weight: 900;font-size: 4em}
    </style>
</head>
<body class="min-vh-100 d-flex flex-column justify-content-center text-center text-white">
<div>
    <h1>COMING SOON</h1>
    <h2 class="shadow-lg mt-5 d-inline-block rounded-pill py-3 px-5"><strong>{{ $site->getDomain() }}</strong> will be launched</h2>
    <p class="mt-5 text-white">Generated by <strong><a href="{{ url('/') }}" class="text-white">Sputnik</a></strong></p>
</div>
</body>
</html>
