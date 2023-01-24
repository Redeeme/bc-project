@extends('layouts.app')
@section('pageTitle', 'grafikonView')
@section('content')
<div>
    <canvas id="myChart"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns"></script>

<script>
    var array = [];
    let array_data = @json($data);
    for (let i = 0;i<18-1;i++){
        array.push(array_data[i]);
        for (let j = 0;j<array[i].length -1;j++) {
            array[i][j].x = Date.parse(`01 Jan 1970 ${array[i][j].x} GMT`)
        }
    }

    let stations = @json($stations);

    const ctx = document.getElementById('myChart');

    const data = {
        datasets: [
            {
                label: 'Dataset 0',
                data: array[0],
                yAxisID: 'y',
                xAxisID: 'x',
            },
            {
                label: 'Dataset 1',
                data: array[1],
                yAxisID: 'y',
                xAxisID: 'x',
            },
            {
                label: 'Dataset 2',
                data: array[2],
                yAxisID: 'y',
                xAxisID: 'x',
            },
            {
                label: 'Dataset 3',
                data: array[3],
                yAxisID: 'y',
                xAxisID: 'x',
            },
            {
                label: 'Dataset 4',
                data: array[4],
                yAxisID: 'y',
                xAxisID: 'x',
            },
            {
                label: 'Dataset 5',
                data: array[5],
                yAxisID: 'y',
                xAxisID: 'x',
            },
            {
                label: 'Dataset 6',
                data: array[6],
                yAxisID: 'y',
                xAxisID: 'x',
            },
            {
                label: 'Dataset 7',
                data: array[7],
                yAxisID: 'y',
                xAxisID: 'x',
            },
            {
                label: 'Dataset 8',
                data: array[8],
                yAxisID: 'y',
                xAxisID: 'x',
            },
            {
                label: 'Dataset 9',
                data: array[9],
                yAxisID: 'y',
                xAxisID: 'x',
            },
            {
                label: 'Dataset 10',
                data: array[10],
                yAxisID: 'y',
                xAxisID: 'x',
            },
            {
                label: 'Dataset 11',
                data: array[11],
                yAxisID: 'y',
                xAxisID: 'x',
            },
            {
                label: 'Dataset 12',
                data: array[12],
                yAxisID: 'y',
                xAxisID: 'x',
            },
            {
                label: 'Dataset 13',
                data: array[13],
                yAxisID: 'y',
                xAxisID: 'x',
            },
            {
                label: 'Dataset 14',
                data: array[14],
                yAxisID: 'y',
                xAxisID: 'x',
            },
            {
                label: 'Dataset 15',
                data: array[15],
                yAxisID: 'y',
                xAxisID: 'x',
            },
            {
                label: 'Dataset 16',
                data: array[16],
                yAxisID: 'y',
                xAxisID: 'x',
            },
            {
                label: 'Dataset 17',
                data: array[17],
                yAxisID: 'y',
                xAxisID: 'x',
            },
        ]
    };
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
                    data: stations,
                    alignToPixels: true,
                    ticks: {
                        // Include a dollar sign in the ticks
                        callback: function(value, index, ticks) {
                            return 'lol' + value;
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
