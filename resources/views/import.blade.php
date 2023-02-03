@extends('layouts.app')
@section('pageTitle', 'Vyber Linky')
@section('content')
    <div class="container">
        <div class="card-header bg-secondary dark bgsize-darken-4 white card-header">
            <h4 class="text-white">Handling Excel Data using PHPSpreadsheet in Laravel</h4>
        </div>
        <div class="row justify-content-centre" style="margin-top: 4%">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bgsize-primary-4 white card-header">
                        <h4 class="card-title">Import Excel Data</h4>
                    </div>
                    <div class="card-body">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>{{ $message }}</strong>
                            </div>
                            <br>
                        @endif
                        <form action="{{route('import-data')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <fieldset>
                                <label>Select File to Upload  <small class="warning text-muted">{{__('Please upload only Excel (.xlsx or .xls) files')}}</small></label>
                                <div class="input-group">
                                    <input type="file" required class="form-control" name="uploaded_file" id="uploaded_file">
                                    @if ($errors->has('uploaded_file'))
                                        <p class="text-right mb-0">
                                            <small class="danger text-muted" id="file-error">{{ $errors->first('uploaded_file') }}</small>
                                        </p>
                                    @endif
                                    <div class="input-group">
                                        <select id="inputCategory" class="form-control" name="table_name">
                                            @foreach($tableNames as $tableName)
                                                <option>{{$tableName->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="dataset">Dataset:</label>
                                        <textarea class="form-control" rows="1" id="dataset"></textarea>
                                    </div>
                                    <div class="input-group-append" id="button-addon2">
                                        <button class="btn btn-primary square" type="submit"><i class="ft-upload mr-2"></i> Upload</button>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
@endsection
