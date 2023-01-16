@extends('layouts.app')
@section('pageTitle', 'charger_selection')
@section('content')
    <div class="col-md-4" >
        <div class="card">
            <div class="card-header">xd</div>
            <div class="card-body">
                <form action="{{route('gantt-page-chargers')}}" method="post">
                    @csrf
                    <input type="hidden" name="cid" value="ahoj">
                    <div class="col-md-6 col-md-offset-3" style="margin-top:50px">
                        <div class="form-group">
                            <label for="inputCategory">Vyber Nabijacku</label>
                            <select id="inputCategory" class="form-control" name="charger">
                                <option selected>Choose...</option>
                                @foreach($chargers as $charger)
                                    <option>{{$charger->charger_id}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form group">
                            <button type="submit" class="btn btn-primary btn-block" id="update_button">UPDATE</button>
                        </div>
                    </div>
                </form>
                <form action="{{route('welcome-page')}}" method="get">
                    <div class="form group">
                        <button type="submit" class="btn btn-danger btn-block" id="update_button">ZRUS</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
