@extends('layouts.app')
@section('pageTitle', 'Zobrazenie dát')
@section('content')
    <div class="container justify-content-center" style="position: relative; height:200vh; width:140vw">
        <canvas id="myChart"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns"></script>

    <script>
        let x = @json($x);
        let y1 = @json($y);
        let y2 = @json($yy);
        const xx = x.map(item => item.x);
        const yy1 = y1.map(item => item.y);
        const yy2 = y2.map(item => item.y);

        const ctx = document.getElementById('myChart').getContext('2d');
        const data = {
            labels: xx,
            datasets: [{
                label: 'Čas strávený na spojoch',
                data: yy1,
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            },
                {
                    label: 'Čas strávený nabíjaním',
                    data: yy2,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
        };
        const options = {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }],
                x: {
                    title: {
                        display: true,
                        text: "{{ $x_label }}"
                    },
                },
                y: {
                    title: {
                        display: true,
                        text: "{{ $y_label }}"
                    }
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: "{{ $name }}"
                }
            },
        };
        const myChart = new Chart(ctx, {
            type: 'bar',
            data: data,
            options: options
        });
    </script>


@endsection
