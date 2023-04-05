@extends('layouts.app')
@section('pageTitle', 'Grafikon')
@section('content')
    <div class="container justify-content-center" style="position: relative; height:70vh; width:140vw">
        <canvas id="myChart"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns"></script>

    <script>
        var array = [];
        let array_data = @json($data);
        let stations = @json($stations);

        const labels = stations.map(item => item.location);
        let min = Date.parse(`13 Mar 2023 03:59:59 GMT`)
        let max = Date.parse(`14 Mar 2023 03:59:59 GMT`)
        for (let i = 0; i < array_data.length; i++) {
            var arrayy = [];
            for (let j = 0; j < array_data[i].length - 1; j++) {
                array_data[i][j].x = Date.parse(`13 Mar 2023 ${array_data[i][j].x} GMT`)
                if (array_data[i][j].x > min) {
                    arrayy.push(array_data[i][j])
                }
            }
            array.push(arrayy);
        }

        const hidden_chart = true;

        var dataa = [];
        for (let i = 0; i < array_data.length; i++) {

            dataa.push({
                label: 'turnus ' + i,
                data: array[i],
                yAxisID: 'y',
                xAxisID: 'x',
                hidden: hidden_chart
            });
        }
        const data = {
            datasets: dataa
        }
        console.log(data);
        const ctx = document.getElementById('myChart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'line',
            data: data,
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Grafikon turnusov'
                    }
                },
                scales: {
                    x: {
                        type: 'time',
                        title: {
                            display: true,
                            text: 'Časy'
                        },
                        time: {
                            unit: 'hour',
                        }
                    },
                    y: {
                        type: 'category',
                        labels: labels,
                        title: {
                            display: true,
                            text: 'Lokácie'
                        }
                    }
                }
            }
        });
    </script>
@endsection
