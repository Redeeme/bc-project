@extends('layouts.app')
@section('pageTitle', 'statsViewUnit')
@section('content')

    @if(isset($tourFlag))
        <div class="card text-center" style="width: 94%; margin-left: 3%">
            <div class="card-header" >
                <ul class="nav nav-tabs card-header-tabs">
                    <li class="nav-item" style="margin-right: 5px">
                        <form action="{{route('gantt-tour')}}" method="post">
                            @csrf
                            <input type="hidden" name="data" value="{{ $tourFlag }}">
                            <input type="hidden" name="dataset" value="{{ $dataset }}">
                            <div class="form group">
                                <button type="submit" class="btn btn-primary btn-block" id="update_button">schema gantt</button>
                            </div>
                        </form>
                    </li>

                    <li class="nav-item" style="margin-right: 5px">
                        <form action="{{route('page-data-table')}}" method="post">
                            @csrf
                            <input type="hidden" name="data" value="{{ $tourFlag }}">
                            <input type="hidden" name="dataset" value="{{ $dataset }}">
                            <input type="hidden" name="name" value="{{ $name }}">
                            <div class="form group">
                                <button type="submit" class="btn btn-primary btn-block" id="update_button">tabulkove zobrazenie</button>
                            </div>
                        </form>
                    </li>

                    <li class="nav-item" style="margin-right: 5px">
                        <form action="{{route('stats-tour')}}" method="post">
                            @csrf
                            <input type="hidden" name="data" value="{{ $tourFlag }}">
                            <input type="hidden" name="dataset" value="{{ $dataset }}">
                            <input type="hidden" name="name" value="{{ $name }}">
                            <div class="form group">
                                <button type="submit" class="btn btn-primary btn-block" id="update_button">statistiky dat</button>
                            </div>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    @endif
    @if(isset($chargerFlag))
        <div class="card text-center" style="width: 94%; margin-left: 3%">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs">

                    <li class="nav-item" style="margin-right: 5px">
                        <form action="{{route('gantt-charger')}}" method="post">
                            @csrf
                            <input type="hidden" name="data" value="{{ $chargerFlag }}">
                            <input type="hidden" name="dataset" value="{{ $dataset }}">
                            <div class="form group">
                                <button type="submit" class="btn btn-primary btn-block" id="update_button">schema gantt</button>
                            </div>
                        </form>
                    </li>

                    <li class="nav-item" style="margin-right: 5px">
                        <form action="{{route('page-data-table')}}" method="post">
                            @csrf
                            <input type="hidden" name="data" value="{{ $chargerFlag }}">
                            <input type="hidden" name="dataset" value="{{ $dataset }}">
                            <input type="hidden" name="name" value="{{ $name }}">
                            <div class="form group">
                                <button type="submit" class="btn btn-primary btn-block" id="update_button">tabulkove zobrazenie</button>
                            </div>
                        </form>
                    </li>

                    <li class="nav-item" style="margin-right: 5px">
                        <form action="{{route('stats-charger')}}" method="post">
                            @csrf
                            <input type="hidden" name="data" value="{{ $chargerFlag }}">
                            <input type="hidden" name="dataset" value="{{ $dataset }}">
                            <input type="hidden" name="name" value="{{ $name }}">
                            <div class="form group">
                                <button type="submit" class="btn btn-primary btn-block" id="update_button">statistiky dat</button>
                            </div>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    @endif
    @if(isset($scheduleFlag))
        <div class="card text-center" style="width: 94%; margin-left: 3%">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs">

                    <li class="nav-item" style="margin-right: 5px">
                        <form action="{{route('gantt-schedule')}}" method="post">
                            @csrf
                            <input type="hidden" name="data" value="{{ $scheduleFlag }}">
                            <input type="hidden" name="type" value="{{ $type }}">
                            <input type="hidden" name="dataset" value="{{ $dataset }}">
                            <input type="hidden" name="name" value="{{ $name }}">
                            <div class="form group">
                                <button type="submit" class="btn btn-primary btn-block" id="update_button">schema gantt</button>
                            </div>
                        </form>
                    </li>

                    <li class="nav-item" style="margin-right: 5px">
                        <form action="{{route('page-data-table')}}" method="post">
                            @csrf
                            <input type="hidden" name="data" value="{{ $scheduleFlag }}">
                            <input type="hidden" name="type" value="{{ $type }}">
                            <input type="hidden" name="dataset" value="{{ $dataset }}">
                            <input type="hidden" name="name" value="{{ $name }}">
                            <div class="form group">
                                <button type="submit" class="btn btn-primary btn-block" id="update_button">tabulkove zobrazenie</button>
                            </div>
                        </form>
                    </li>

                    <li class="nav-item" style="margin-right: 5px">
                        <form action="{{route('stats-schedule')}}" method="post">
                            @csrf
                            <input type="hidden" name="data" value="{{ $scheduleFlag }}">
                            <input type="hidden" name="type" value="{{ $type }}">
                            <input type="hidden" name="dataset" value="{{ $dataset }}">
                            <input type="hidden" name="name" value="{{ $name }}">
                            <div class="form group">
                                <button type="submit" class="btn btn-primary btn-block" id="update_button">statistiky dat</button>
                            </div>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    @endif
    @if(isset($stats))
        <div class="articles-wrapper" style="width: 94%; margin-left: 3%">
            @foreach($stats as $stat)
                <div class="article-card">
                    <div class="image">
                    </div>
                    <h3>{{$stat['name']}}</h3>
                    <div class="description">
                        {{$stat['stat']}}
                    </div>
                </div>
            @endforeach
    @endif
@endsection
