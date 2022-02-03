<!DOCTYPE html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <script src="https://static.fusioncharts.com/code/latest/fusioncharts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore.js"></script>
    <link href="https://cdn.dhtmlx.com/gantt/edge/dhtmlxgantt.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style type="text/css">
        html,body{
            height: 100%;
            padding: 0px;
            margin: 0px;
            overflow: hidden;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand">
            bc-project
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                <li class="nav-item">
                    <a class="nav-link" href="{{route('welcome-page')}}">Domov</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('gantt-page')}}">Gantt</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<script>

    // let processes = [{"label":"2","id":"2"},
    //     {"label":"3","id":"3"},
    //     {"label":"33","id":"33"},
    //     {"label":"34","id":"34"},
    //     {"label":"4","id":"4"}]
    //
    // let task = [{"processid":"2","start":"05:57:00","end":"05:21:00","label":"92 160 2022-11-18 05:57:00 2022-11-18 05:21:00 10.486 11.0"},
    //     {"processid":"3","start":"05:23:00","end":"06:12:00","label":"160 160 2022-11-18 05:23:00 2022-11-18 06:12:00 19.565 21.0"},
    //     {"processid":"33","start":"05:26:00","end":"06:50:00","label":"92 160 2022-11-18 05:26:00 2022-11-18 06:50:00 10.486 11.0"},
    //     {"processid":"34","start":"06:03:00","end":"07:52:00","label":"160 160 2022-11-18 06:03:00 2022-11-18 07:52:00 19.565 21.0"},
    //     {"processid":"4","start":"07:33:00","end":"07:22:00","label":"160 160 2022-11-18 07:33:00 2022-11-18 07:22:00 19.565 21.0"}]

    let array_process = @json($processes);
    let array_task = @json($task);
    let array_categories = @json($categories);

    const dataSource = {
        tasks: {
            showlabels: "1",
            color: "#f16575",
            task:  array_task
        },
        processes: {
            fontsize: "20",
            isbold: "1",
            align: "Center",
            headertext: "Linky",
            headerfontsize: "14",
            headervalign: "middle",
            headeralign: "left",
            process: array_process
        },
        categories: [
            {

                category: [
                    {
                        start: "00:00:00",
                        end: "23:59:59",
                        label: "Time"
                    }
                ]
            },
            {
                fontsize: "25",
                align: "center",
                category: array_categories
            }
        ],
        chart: {
            dateformat: "dd/mm/yyyy",
            outputdateformat: "hh12:mn ampm",
            caption: "Shift Roster for June",
            subcaption: "Customer Success Team<br>Sensibill",
            ganttpaneduration: "22",
            ganttpanedurationunit: "h",
            scrolltodate: "09:00:00",
            useverticalscrolling: "0",
            theme: "fusion"
        }
    };

    FusionCharts.ready(function() {
        var myChart = new FusionCharts({
            type: "gantt",
            renderAt: "chart-container",
            width: "100%",
            height: "100%",
            dataFormat: "json",
            dataSource
        }).render();
        myChart.setJSONData(dataSource);
    });
</script>
<div id="chart-container"></div>
</body>
