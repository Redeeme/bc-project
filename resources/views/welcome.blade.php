@extends('layouts.app')
@section('pageTitle', 'welcome')
@section('content')
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
            <h3>schema zobrazeni gannt diagramu linie</h3>
            <div class="description">
                description
            </div>
        </div>
    </div>
@endsection
