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
        function getRandomColor(firstValue) {
            const randomValue = (min) => Math.floor(Math.random() * (256 - min) + min);
            const randomAlpha = () => (Math.random() * 0.5 + 0.5).toFixed(2); // Generate random alpha between 0.5 and 1

            return {
                backgroundColor: `rgba(${firstValue}, ${randomValue()}, ${randomValue()}, ${randomAlpha()})`,
                borderColor: `rgba(${firstValue}, ${randomValue()}, ${randomValue()}, 1)`
            };
        }

        // Usage:
        const firstValue = 255; // The fixed first value
        const randomColors = getRandomColor(firstValue);
        console.log(randomColors);
        const data = {
            labels: xx,
            datasets: [{
                label: "data",
                data: yy,
                backgroundColor: 'rgb(31,110,202)',
                borderColor: 'rgb(31,110,202)',
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
