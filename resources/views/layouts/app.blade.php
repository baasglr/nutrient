<!doctype html>
<html lang="en">
<head>
    <title>@yield('title')</title>
    <style>
        .active {
            font-weight: bold;
            color: red;
        }
    </style>
    @vite('resources/css/app.css')
</head>
<body>
@include('partials.nav')
<div>@yield('content')</div>
</body>
</html>
