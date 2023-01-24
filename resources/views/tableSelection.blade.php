@extends('layouts.app')
@section('pageTitle', 'dataTable_selection')
@section('content')
    <div class="col-md-4" >
        <div class="card">
            <div class="card-header">xd</div>
            <div class="card-body">
                <form action="{{route('page-data-table')}}" method="post">
                    @csrf
                    <input type="hidden" name="cid" value="ahoj">
                    <div class="col-md-6 col-md-offset-3" style="margin-top:50px">
                        <div class="form-group">
                            <label for="inputCategory">Vyber Linky</label>
                            <select id="inputCategory" class="form-control" name="name">
                                <option selected>Choose...</option>
                                @foreach($tableNames as $tableName)
                                    <option>{{$tableName->name}}</option>
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