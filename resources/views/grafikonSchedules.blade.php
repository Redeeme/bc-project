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
        let min = Date.parse(`01 Jan 1970 03:59:59 GMT`)
        let max = Date.parse(`01 Jan 1970 23:59:59 GMT`)
        for (let i = 0;i<48-1;i++){
            var arrayy = [];
            for (let j = 0;j<array_data[i].length - 1;j++) {
                array_data[i][j].x = Date.parse(`01 Jan 1970 ${array_data[i][j].x} GMT`)
                if (array_data[i][j].x > min){
                    arrayy.push(array_data[i][j])
                }
            console.log(array[i]);
            }
            array.push(arrayy);
        }

        const ctx = document.getElementById('myChart');

        const data = {
            datasets: [
                {
                    label: 'turnus 0',
                    data: array[0],
                    yAxisID: 'y',
                    xAxisID: 'x',
                },
                {
                    label: 'turnus 1',
                    data: array[1],
                    yAxisID: 'y',
                    xAxisID: 'x',
                },
                {
                    label: 'turnus 2',
                    data: array[2],
                    yAxisID: 'y',
                    xAxisID: 'x',
                },
                {
                    label: 'turnus 3',
                    data: array[3],
                    yAxisID: 'y',
                    xAxisID: 'x',
                },
                {
                    label: 'turnus 4',
                    data: array[4],
                    yAxisID: 'y',
                    xAxisID: 'x',
                },
                {
                    label: 'turnus 5',
                    data: array[5],
                    yAxisID: 'y',
                    xAxisID: 'x',
                },
                {
                    label: 'turnus 6',
                    data: array[6],
                    yAxisID: 'y',
                    xAxisID: 'x',
                },
                {
                    label: 'turnus 7',
                    data: array[7],
                    yAxisID: 'y',
                    xAxisID: 'x',
                },
                {
                    label: 'turnus 8',
                    data: array[8],
                    yAxisID: 'y',
                    xAxisID: 'x',
                },
                {
                    label: 'turnus 9',
                    data: array[9],
                    yAxisID: 'y',
                    xAxisID: 'x',
                },
                {
                    label: 'turnus 10',
                    data: array[10],
                    yAxisID: 'y',
                    xAxisID: 'x',
                },
                {
                    label: 'turnus 11',
                    data: array[11],
                    yAxisID: 'y',
                    xAxisID: 'x',
                },
                {
                    label: 'turnus 12',
                    data: array[12],
                    yAxisID: 'y',
                    xAxisID: 'x',
                },
                {
                    label: 'turnus 13',
                    data: array[13],
                    yAxisID: 'y',
                    xAxisID: 'x',
                },
                {
                    label: 'turnus 14',
                    data: array[14],
                    yAxisID: 'y',
                    xAxisID: 'x',
                },
                {
                    label: 'turnus 15',
                    data: array[15],
                    yAxisID: 'y',
                    xAxisID: 'x',
                },
                {
                    label: 'turnus 16',
                    data: array[16],
                    yAxisID: 'y',
                    xAxisID: 'x',
                },
                {
                    label: 'turnus 17',
                    data: array[17],
                    yAxisID: 'y',
                    xAxisID: 'x',
                },
                {
                    label: 'turnus 18',
                    data: array[18],
                    yAxisID: 'y',
                    xAxisID: 'x',
                },
                {
                    label: 'turnus 19',
                    data: array[19],
                    yAxisID: 'y',
                    xAxisID: 'x',
                },
                {
                    label: 'turnus 20',
                    data: array[20],
                    yAxisID: 'y',
                    xAxisID: 'x',
                },
                {
                    label: 'turnus 21',
                    data: array[21],
                    yAxisID: 'y',
                    xAxisID: 'x',
                },
                {
                    label: 'turnus 22',
                    data: array[22],
                    yAxisID: 'y',
                    xAxisID: 'x',
                },                {
                    label: 'turnus 23',
                    data: array[23],
                    yAxisID: 'y',
                    xAxisID: 'x',
                },
                {
                    label: 'turnus 24',
                    data: array[24],
                    yAxisID: 'y',
                    xAxisID: 'x',
                },
                {
                    label: 'turnus 25',
                    data: array[25],
                    yAxisID: 'y',
                    xAxisID: 'x',
                },
                {
                    label: 'turnus 26',
                    data: array[26],
                    yAxisID: 'y',
                    xAxisID: 'x',
                },
                {
                    label: 'turnus 27',
                    data: array[27],
                    yAxisID: 'y',
                    xAxisID: 'x',
                },
                {
                    label: 'turnus 28',
                    data: array[28],
                    yAxisID: 'y',
                    xAxisID: 'x',
                },
                {
                    label: 'turnus 29',
                    data: array[29],
                    yAxisID: 'y',
                    xAxisID: 'x',
                },
                {
                    label: 'turnus 30',
                    data: array[30],
                    yAxisID: 'y',
                    xAxisID: 'x',
                },                {
                    label: 'turnus 31',
                    data: array[31],
                    yAxisID: 'y',
                    xAxisID: 'x',
                },
                {
                    label: 'turnus 32',
                    data: array[32],
                    yAxisID: 'y',
                    xAxisID: 'x',
                },
                {
                    label: 'turnus 33',
                    data: array[33],
                    yAxisID: 'y',
                    xAxisID: 'x',
                },
                {
                    label: 'turnus 34',
                    data: array[34],
                    yAxisID: 'y',
                    xAxisID: 'x',
                },
                {
                    label: 'turnus 35',
                    data: array[35],
                    yAxisID: 'y',
                    xAxisID: 'x',
                },
                {
                    label: 'turnus 36',
                    data: array[36],
                    yAxisID: 'y',
                    xAxisID: 'x',
                },
                {
                    label: 'turnus 37',
                    data: array[37],
                    yAxisID: 'y',
                    xAxisID: 'x',
                },
                {
                    label: 'turnus 38',
                    data: array[38],
                    yAxisID: 'y',
                    xAxisID: 'x',
                },                {
                    label: 'turnus 39',
                    data: array[39],
                    yAxisID: 'y',
                    xAxisID: 'x',
                },
                {
                    label: 'turnus 40',
                    data: array[40],
                    yAxisID: 'y',
                    xAxisID: 'x',
                },
                {
                    label: 'turnus 41',
                    data: array[41],
                    yAxisID: 'y',
                    xAxisID: 'x',
                },
                {
                    label: 'turnus 42',
                    data: array[42],
                    yAxisID: 'y',
                    xAxisID: 'x',
                },
                {
                    label: 'turnus 43',
                    data: array[43],
                    yAxisID: 'y',
                    xAxisID: 'x',
                },
                {
                    label: 'turnus 44',
                    data: array[44],
                    yAxisID: 'y',
                    xAxisID: 'x',
                },
                {
                    label: 'turnus 45',
                    data: array[45],
                    yAxisID: 'y',
                    xAxisID: 'x',
                },
                {
                    label: 'turnus 46',
                    data: array[46],
                    yAxisID: 'y',
                    xAxisID: 'x',
                },                {
                    label: 'turnus 47',
                    data: array[47],
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
                        alignToPixels: true,
                        ticks: {
                            min: 1,
                            max: 44,
                            stepSize: 1,
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
