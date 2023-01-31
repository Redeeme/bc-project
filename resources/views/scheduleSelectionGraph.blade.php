@extends('layouts.app')
@section('pageTitle', 'schedule_selection')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-2 mt-5">
                <div class="card">
                    <div class="card-header bg-info">
                        <h6 class="text-white">Laravel Multiple Select Dropdown with Checkbox Example - ItSolutionStuff.com</h6>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{route('graph-page-schedules')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="">
                                <label><strong>Vyber turnusu</strong></label>
                                <select class="selectpicker" multiple data-live-search="true" name="schedule[]">
                                    @foreach($schedules as $schedule)
                                        <option value="{{$schedule->schedule_no}}">{{$schedule->schedule_no}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="">
                                <label><strong>Vyber typu akcie</strong></label>
                                <select id="inputCategory" class="form-control" name="type">
                                    <option selected>BOTH</option>
                                    @foreach($categories as $category)
                                        <option>{{$category->type}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="text-center" style="margin-top: 10px;">
                                <button type="submit" class="btn btn-success">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>





    <!-- Initialize the plugin: -->

    <script type="text/javascript">

        $(document).ready(function() {

            $('select').selectpicker();

        });

    </script>


@endsection
