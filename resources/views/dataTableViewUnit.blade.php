@extends('layouts.app')
@section('pageTitle', 'Zobrazenie dát')
@section('content')

    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>

    @if(isset($tourFlag))
        <div class="card text-center" style="width: 94%; margin-left: 3%">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs">
                    <li class="nav-item" style="margin-right: 5px">
                        <form action="{{route('gantt-tour')}}" method="post">
                            @csrf
                            <input type="hidden" name="data" value="{{ $tourFlag }}">
                            <input type="hidden" name="dataset" value="{{ $dataset }}">
                            <div class="form group">
                                <button type="submit" class="btn btn-primary btn-block" id="update_button">Schéma Ganttov diagramu
                                </button>
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
                                <button type="submit" class="btn btn-primary btn-block" id="update_button">Tabuľkové zobrazenie
                                </button>
                            </div>
                        </form>
                    </li>

                    <li class="nav-item" style="margin-right: 5px; display: none;">
                        <form action="{{route('stats-tour')}}" method="post">
                            @csrf
                            <input type="hidden" name="data" value="{{ $tourFlag }}">
                            <input type="hidden" name="dataset" value="{{ $dataset }}">
                            <div class="form group">
                                <button type="submit" class="btn btn-primary btn-block" id="update_button">Štatistiky dát
                                </button>
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
                                <button type="submit" class="btn btn-primary btn-block" id="update_button">Schéma Ganttov diagramu
                                </button>
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
                                <button type="submit" class="btn btn-primary btn-block" id="update_button">Tabuľkové zobrazenie
                                </button>
                            </div>
                        </form>
                    </li>

                    <li class="nav-item" style="margin-right: 5px; display: none;">
                        <form action="{{route('stats-charger')}}" method="post">
                            @csrf
                            <input type="hidden" name="data" value="{{ $chargerFlag }}">
                            <input type="hidden" name="dataset" value="{{ $dataset }}">
                            <input type="hidden" name="name" value="{{ $name }}">
                            <div class="form group">
                                <button type="submit" class="btn btn-primary btn-block" id="update_button">Štatistiky dát
                                </button>
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
                                <button type="submit" class="btn btn-primary btn-block" id="update_button">Schéma Ganttov diagramu
                                </button>
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
                                <button type="submit" class="btn btn-primary btn-block" id="update_button">Tabuľkové zobrazenie
                                </button>
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
                                <button type="submit" class="btn btn-primary btn-block" id="update_button">Štatistiky dát
                                </button>
                            </div>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    @endif
    <section style="padding-top: 60px;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    {!! $dataTable->table() !!}
                </div>
            </div>
        </div>
    </section>
    {!! $dataTable->scripts() !!}


@endsection
