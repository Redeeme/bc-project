@extends('layouts.app')
@section('pageTitle', 'grafikonView')
@section('content')
    <div class="container justify-content-center" style="position: relative; height:70vh; width:140vw">
        <canvas id="myChart"></canvas>
    </div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns"></script>

<script>
    var array = [];
    let array_data = @json($data);
    let stations = @json($stationsNames);
    for (let i = 0;i<18-1;i++){
        array.push(array_data[i]);
        for (let j = 0;j<array[i].length;j++) {
            array[i][j].x = Date.parse(`01 Jan 1970 ${array[i][j].x} GMT`)
            array[i][j].x -= 3600000

        }
        array[i].sort(function(a, b) {
            var c = a.x;
            var d = b.x;
            return a.x-b.x;
        });
    }

    const ctx = document.getElementById('myChart');
    let data = {};

    for (let i = 0;i<18-1;i++){
        data = {
            dataset: [
                {
                    label: 'Linka '+i,
                    data: array[i],
                    yAxisID: 'y',
                    xAxisID: 'x',
                }
            ]
        };
    }

    /*const data = {
        datasets: [
            {
                label: 'Linka 0',
                data: array[0],
                yAxisID: 'y',
                xAxisID: 'x',
            },
            {
                label: 'Linka 1',
                data: array[1],
                yAxisID: 'y',
                xAxisID: 'x',
            },
            {
                label: 'Linka 2',
                data: array[2],
                yAxisID: 'y',
                xAxisID: 'x',
            },
            {
                label: 'Linka 3',
                data: array[3],
                yAxisID: 'y',
                xAxisID: 'x',
            },
            {
                label: 'Linka 4',
                data: array[4],
                yAxisID: 'y',
                xAxisID: 'x',
            },
            {
                label: 'Linka 5',
                data: array[5],
                yAxisID: 'y',
                xAxisID: 'x',
            },
            {
                label: 'Linka 6',
                data: array[6],
                yAxisID: 'y',
                xAxisID: 'x',
            },
            {
                label: 'Linka 7',
                data: array[7],
                yAxisID: 'y',
                xAxisID: 'x',
            },
            {
                label: 'Linka 8',
                data: array[8],
                yAxisID: 'y',
                xAxisID: 'x',
            },
            {
                label: 'Linka 9',
                data: array[9],
                yAxisID: 'y',
                xAxisID: 'x',
            },
            {
                label: 'Linka 10',
                data: array[10],
                yAxisID: 'y',
                xAxisID: 'x',
            },
            {
                label: 'Linka 11',
                data: array[11],
                yAxisID: 'y',
                xAxisID: 'x',
            },
            {
                label: 'Linka 12',
                data: array[12],
                yAxisID: 'y',
                xAxisID: 'x',
            },
            {
                label: 'Linka 13',
                data: array[13],
                yAxisID: 'y',
                xAxisID: 'x',
            },
            {
                label: 'Linka 14',
                data: array[14],
                yAxisID: 'y',
                xAxisID: 'x',
            },
            {
                label: 'Linka 15',
                data: array[15],
                yAxisID: 'y',
                xAxisID: 'x',
            },
            {
                label: 'Linka 16',
                data: array[16],
                yAxisID: 'y',
                xAxisID: 'x',
            },
            {
                label: 'Linka 17',
                data: array[17],
                yAxisID: 'y',
                xAxisID: 'x',
            },
        ]
    };*/
    new Chart(ctx, {
        type: 'line',
        data: data,
        options: {
            responsive: true,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            stacked: false,
            plugins: {
                title: {
                    display: true,
                    text: 'Chart.js Line Chart - Multi Axis'
                }
            },
            scales: {
                y: {
                    type: 'linear',
                    display: true,
                    alignToPixels: true,
                        ticks: {
                            min: 0,
                            max: 44,
                            stepSize: 1,
                            callback: function (label, index, labels) {
                                for (let i = 0; i < 44 - 1; i++) {
                                    if (label === i) {
                                        return stations[i];
                                    }
                                }
                            }
                        }
                    // grid line settings
                },
                x: {
                    type: 'time',
                    time: {
                        unit: 'hour',
                    }
                }
            }
        },
    });
    //TODO x y axis labels! assign stations data to y axis
</script>


@endsection
