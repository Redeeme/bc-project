@extends('layouts.app')
@section('pageTitle', 'dataTableView')
@section('content')

{{--    <div class="container">
        <div class="row" style="margin-top: 45px">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">dataTable view</div>
                    <div class="card-body">
                        <table class="table table-hover table-condensed" id="data_table">
                            <thead>
                            <th>charger_task_id</th>
                            <th>charger_id</th>
                            <th>process_id</th>
                            <th>label</th>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        toastr.options.preventDuplicates = true;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(function () {
                $('#data_table').DataTable({
                    processing: true,
                    serverside: true,
                    info: true,
                    ajax: "{{route('get-Charger-Tasks')}}",
                    columns: [
                        {data: 'charger_task_id', name: 'charger_task_id'},
                        {data: 'charger_id', name: 'charger_id'},
                        {data: 'process_id', name: 'process_id'},
                        {data: 'label', name: 'label'},
                    ]
                });
        });
    </script>--}}
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
