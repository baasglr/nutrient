<!doctype html>
<html lang="en">
<head>
    <title>@yield('title')</title>
    <style>
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }
        .overlay.active {
            display: flex;
        }
    </style>
    @vite('resources/css/app.css')
</head>
<body>
@include('partials.nav')
<div>@yield('content')</div>
</body>
</html>
