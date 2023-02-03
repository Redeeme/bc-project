@extends('layouts.app')
@section('pageTitle', 'welcome')
@section('content')
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
                    schema zobrazenie gantt diagramu vybranej linky
                </a>
            </h3>
            <div class="description">
                description
            </div>
        </div>
        <div class="article-card">
            <div class="image">
            </div>
            <h3>
                <a href="{{route('select-chargers')}}">
                schema zobrazenie gantt diagramu vybranej nabijacky
                </a>
            </h3>
            <div class="description">
                description
            </div>
        </div>
        <div class="article-card">
            <div class="image">
            </div>
            <h3>
                <a href="{{route('select-schedules')}}">
                    schema zobrazenie gantt diagramu vybraneho rozvrhu podla typu akcie
                </a>
            </h3>
            <div class="description">
                description
            </div>
        </div>
        <div class="article-card">
            <div class="image">
            </div>
            <h3>
                <a href="{{route('select-table-view')}}">
                    tabulkove zobrazenie vybranych dat
                </a>
            </h3>
            <div class="description">
                description
            </div>
        </div>
        <div class="article-card">
            <div class="image">
            </div>
            <h3>
                <a href="{{route('select-task-grafikon')}}">
                    grafikon liniek
                </a>
            </h3>
            <div class="description">
                description
            </div>
        </div>
        <div class="article-card">
            <div class="image">
            </div>
            <h3>
                <a href="{{route('select-schedule-grafikon')}}">
                    grafikon turnusov
                </a>
            </h3>
            <div class="description">
                description
            </div>
        </div>
        <div class="article-card">
            <div class="image">
            </div>
            <h3>
                <a href="{{route('select-schedules-graph')}}">
                    graf stavu nabijania turnusov
                </a>
            </h3>
            <div class="description">
                description
            </div>
        </div>
        <div class="article-card">
            <div class="image">
            </div>
            <h3>
                <a href="{{route('import-upload')}}">
                    import new dataset
                </a>
            </h3>
            <div class="description">
                description
            </div>
        </div>
    </div>
@endsection
