@extends('layouts.app')
@section('pageTitle', 'gantt')
@section('content')
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
        let array_category = @json($category);
        let palette = Math.floor(Math.random() * 5);
        let tourNumber = @json($tour);

        const dataSource = {
            tasks: {
                showlabels: "0",
                color: "#f16575",
                fontsize: "30",
                task: array_task
            },
            processes: {
                fontsize: "20",
                isbold: "1",
                align: "Center",
                headertext: "Spoje",
                headerfontsize: "14",
                headervalign: "middle",
                headeralign: "left",
                process: array_process
            },
            categories: [
                {

                    category: [
                        {
                            start: array_category[0].start,
                            end: array_category[0].end,
                            label: array_category[0].label
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
                caption: "linka číslo: " + tourNumber,
                ganttpaneduration: "20",
                ganttpanedurationunit: "h",
                useverticalscrolling: "0",
                theme: "fusion",
                palette: palette
            }
        };

        FusionCharts.ready(function () {
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
@endsection
