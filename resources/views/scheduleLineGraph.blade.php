@extends('layouts.app')
@section('pageTitle', 'grafikonView')
@section('content')
    <div class="container justify-content-center" style="position: relative; height:200vh; width:140vw">
        <canvas id="myChart"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns"></script>

    <script>
        var array = [];
        let array_data = @json($data);
        let min = Date.parse(`01 Jan 1970 03:59:59 GMT`)
        let max = Date.parse(`01 Jan 1970 23:59:59 GMT`)
        for (let i = 0; i < array_data.length - 1; i++) {
            array_data[i].x = Date.parse(`01 Jan 1970 ${array_data[i].x} GMT`)
            if (array_data[i].x > min) {
                array.push(array_data[i])
            }
        }
        console.log(array);

        const ctx = document.getElementById('myChart');

        const data = {
            datasets: [
                {
                    label: 'turnus 0',
                    data: array,
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
