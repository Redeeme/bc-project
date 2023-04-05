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
        let y1 = @json($y1);
        let y2 = @json($y2);
        let y3 = @json($y3);
        let y4 = @json($y4);
        const xx = x.map(item => item.x);
        const yy1 = y1.map(item => item.y);
        const yy2 = y2.map(item => item.y);
        const yy3 = y3.map(item => item.y);
        const yy4 = y4.map(item => item.y);

        var ctx = document.getElementById('myChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: xx,
                datasets: [
                    {
                        label: 'Ráno',
                        data: yy1,
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Obed',
                        data: yy2,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Večer',
                        data: yy3,
                        backgroundColor: 'rgba(255, 206, 86, 0.2)',
                        borderColor: 'rgba(255, 206, 86, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Noc',
                        data: yy4,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
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
            }
        });
    </script>
@endsection
