@extends('layouts.app')
@section('pageTitle', 'schedule_selection')
@section('content')
    <div class="col-md-4" >
        <div class="card">
            <div class="card-header">xd</div>
            <div class="card-body">
                <form action="{{route('gantt-page-schedules')}}" method="post">
                    @csrf
                    <input type="hidden" name="cid" value="ahoj">
                    <div class="col-md-6 col-md-offset-3" style="margin-top:50px">
                        <div class="form-group">
                            <label for="inputCategory">Vyber turnusu</label>
                            <select id="inputCategory" class="form-control" name="schedule">
                                <option selected>Choose...</option>
                                @foreach($schedules as $schedule)
                                    <option>{{$schedule->schedule_no}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="inputCategory">Vyber typu akcie</label>
                            <select id="inputCategory" class="form-control" name="type">
                                <option selected>Choose...</option>
                                @foreach($categories as $category)
                                    <option>{{$category->type}}</option>
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
