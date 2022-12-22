@extends('adminlte::page')

@section('title', 'List Grafik')

@section('content_header')
    <h1>Dashboard 2</h1>
@stop

@section('content')
    <p>Welcome to this beautiful admin panel.</p>
    <div class="container-fluid">
        <div class="row">
            <div class="card card-danger">
                <div class="card-header">
                    <h3 class="card-title">Pie Chart</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <h1>Laravel 9 Charts JS Example Tutorial - Nicesnippets.com</h1>
                    <canvas id="myChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </div>
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">Pie Chart 2</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <h1>Laravel 9 Charts JS Example Tutorial - Nicesnippets.com</h1>
                    <canvas id="myChart2" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script type="text/javascript">
        // var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
        // var pieData        = {
        //     // labels: [
        //     //     'Chrome',
        //     //     'IE',
        //     //     'FireFox',
        //     //     'Safari',
        //     //     'Opera',
        //     //     'Navigator',
        //     // ],
        //     // datasets: [
        //     //     {
        //     //     data: [700,500,400,600,300,100],
        //     //     backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
        //     //     }
        //     // ]
        //     labels: [
        //         'Pending',
        //         'Approved',
        //         'In Progress',
        //     ],
        //     datasets: [
        //         {
        //         data: [700,500,400],
        //         backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
        //         }
        //     ]
        // }
        // var pieOptions     = {
        // maintainAspectRatio : false,
        // responsive : true,
        // }
        // //Create pie or douhnut chart
        // // You can switch between pie and douhnut using the method below.
        // new Chart(pieChartCanvas, {
        // type: 'pie',
        // data: pieData,
        // options: pieOptions
        // })
        var labels =  {{ Js::from($labels) }};
        var users =  {{ Js::from($data) }};
        var labels2 =  {{ Js::from($labels2) }};
        var users2 =  {{ Js::from($data2) }};
    
        const data = {
            labels: labels,
            datasets: [{
                label: 'Data bedasarkan Status',
                backgroundColor: ['#f56954', '#00a65a', '#f39c12'],
                borderColor: ['#f56954', '#00a65a', '#f39c12'],
                data: users,
            }]
        };

        const data2 = {
            labels: labels2,
            datasets: [{
                label: 'Data bedasarkan Status',
                backgroundColor: ['#f56954', '#00a65a', '#f39c12'],
                borderColor: ['#f56954', '#00a65a', '#f39c12'],
                data: users2,
            }]
        };
    
        const config = {
            type: 'pie',
            data: data,
            options: {}
        };

        const config2 = {
            type: 'pie',
            data: data2,
            options: {}
        };
    
        const myChart = new Chart(
            document.getElementById('myChart'),
            config
        );

        const myChart2 = new Chart(
            document.getElementById('myChart2'),
            config2
        );
    </script>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop

<script>

</script>