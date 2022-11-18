@extends('layouts.app')
@section('pageTitle', 'welcome')
@section('content')
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
@endsection
