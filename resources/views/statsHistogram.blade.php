@extends('layouts.app')
@section('pageTitle', 'grafikonView')
@section('content')
    <div class="container justify-content-center" style="position: relative; height:200vh; width:140vw">
        <canvas id="myChart"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns"></script>

    <script>
        let x = @json($x);
        let y = @json($y);
        console.log(x);
        console.log(y);
        const xx = x.map(item => item.x);
        const yy = y.map(item => item.y);

        const ctx = document.getElementById('myChart').getContext('2d');
        const data = {
            labels: xx,
            datasets: [{
                label: "{{ $type }}",
                data: yy,
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        };
        const options = {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        };
        const myChart = new Chart(ctx, {
            type: 'bar',
            data: data,
            options: options
        });
    </script>


@endsection
