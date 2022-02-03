<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/css.css?v=') . time() }}" rel="stylesheet">

</head>
<body>
<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand">
            bc-project
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                <li class="nav-item">
                    <a class="nav-link" href="{{route('welcome-page')}}">Domov</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="articles-wrapper">
    <div class="article-card">
        <div class="image">
        </div>
        <h3>
            <a href="{{route('select-tours')}}">
                schema zobrazenie gantt diagramu vozidiel
            </a>
        </h3>
        <div class="description">
            description
        </div>
    </div>
    <div class="article-card">
        <div class="image">
        </div>
        <h3>schema zobrazenie liniek pomocou grafu</h3>
        <div class="description">
            description
        </div>
    </div>
    <div class="article-card">
        <div class="image">
        </div>
        <h3>schema zobrazeni gannt diagramu linie</h3>
        <div class="description">
            description
        </div>
    </div>
</div>
</body>
</html>
