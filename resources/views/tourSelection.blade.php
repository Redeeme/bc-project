@extends('layouts.app')
@section('pageTitle', 'Vyber Linky')
@section('content')
    <div class="col-md-4" >
    <div class="card">
        <div class="card-header">xd</div>
        <div class="card-body">
            <form action="{{route('gantt-page-tours')}}" method="post">
                @csrf
                <input type="hidden" name="cid" value="ahoj">
                <div class="col-md-6 col-md-offset-3" style="margin-top:50px">
                    <div class="form-group">
                        <label for="inputCategory">Vyber Linky</label>
                        <select id="inputCategory" class="form-control" name="linka">
                            <option selected>Choose...</option>
                            @foreach($tours as $tour)
                                <option>{{$tour->linka}}</option>
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
