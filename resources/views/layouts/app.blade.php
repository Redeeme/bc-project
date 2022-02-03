<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('pageTitle')</title>
    <style type="text/css">
        html,body{
            height: 100%;
            padding: 0px;
            margin: 0px;
            overflow: hidden;
        }
    </style>
    <script src="https://cdn.dhtmlx.com/gantt/edge/dhtmlxgantt.js"></script>

</head>
<body>
<main class="py-4">
    @yield('content')
</main>
</body>
</html>
