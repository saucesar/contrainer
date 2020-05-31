@extends('layouts.app', ['activePage' => 'admin-area', 'titlePage' => __("Admin Area")])

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">laptop</i>
                        </div>
                        <p class="card-category">Machines</p>
                        <h3 class="card-title">{{ $numberOfMach }}</h3>
                        <div class="collapse card-title" id="machine-details">
                            <br>
                            <p>Active: {{ $inActivity }}</p>
                            <a href="{{ route('admin.area.machines') }}" class="btn btn-warning">full list</a>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a rel="tooltip" class="btn btn-link" data-toggle="collapse" data-target="#machine-details"
                            aria-expanded="false" aria-controls="collapseExample">
                            <i class="material-icons ">expand_more</i>
                            More Details
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">people</i>
                        </div>
                        <p class="card-category">Users</p>
                        <h3 class="card-title">{{ $numberOfUsers }}</h3>
                        <div class="collapse" id="users-details">
                            <table class='table'>
                                <tbody>
                                    <tr>
                                        <td>Today:</td>
                                        <td>{{ $registeredToday }}</td>
                                    </tr>
                                    <tr>
                                        <td>This Month:</td>
                                        <td>{{ $registeredMonth }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <a href="{{ route('admin.area.users') }}" class="btn btn-warning">full list</a>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a rel="tooltip" class="btn btn-link" data-toggle="collapse" data-target="#users-details"
                            aria-expanded="false" aria-controls="collapseExample">
                            <i class="material-icons">expand_more</i>
                            More Details
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">album</i>
                        </div>
                        <p class="card-category">Images</p>
                        <h3 class="card-title">{{ $numberOfCont }}</h3>
                        <div class="collapse card-title" id="container-details">
                            <table class='table'>
                                <thead>
                                    <th>Image</th>
                                    <th>Instances</th>
                                </thead>
                                <tbody>
                                    @foreach($containers as $container)
                                    <tr>
                                        <td>{{ $container->name }}</td>
                                        <td>{{ $instacesOfeachImage[$container->id] }}</td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a rel="tooltip" class="btn btn-link" data-toggle="collapse" data-target="#container-details"
                            aria-expanded="false" aria-controls="collapseExample">
                            <i class="material-icons">expand_more</i>
                            More Details
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">album</i>
                        </div>
                        <p class="card-category">Instances</p>
                        <h3 class="card-title">{{ $numberOfCont }}</h3>
                        <div class="collapse card-title" id="container-details">
                            <table class='table'>
                                <thead>
                                    <th>Image</th>
                                    <th>Instances</th>
                                </thead>
                                <tbody>
                                    @foreach($containers as $container)
                                    <tr>
                                        <td>{{ $container->name }}</td>
                                        <td>{{ $instacesOfeachImage[$container->id] }}</td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a rel="tooltip" class="btn btn-link" data-toggle="collapse" data-target="#container-details"
                            aria-expanded="false" aria-controls="collapseExample">
                            <i class="material-icons">expand_more</i>
                            More Details
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-lg-6">
                <div class="card card-stats">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">assessment</i>
                        </div>
                        <canvas id="chartMachines"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card card-stats">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">assessment</i>
                        </div>
                        <canvas id="chartUsers"></canvas>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">

            <div class="col-lg-12">
                <div class="card card-stats">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">assessment</i>
                        </div>
                        <canvas id="chartImages"></canvas>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection

@push('js')
<script>
$(document).ready(function() {
    // Javascript method's body can be found in assets/js/demos.js
    md.initDashboardPageCharts();
});
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>

<script>
var ctx = document.getElementById('chartImages').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?= $imagesLabel; ?>,
        datasets: [{
            label: 'Instances per Image',
            data: <?= $graficDataImages; ?> ,
            backgroundColor : [
                'rgba(75, 192, 192, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(75, 192, 192, 0.2)',
            ],
            borderColor: [
                'rgba(75, 192, 192, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(75, 192, 192, 1)',
            ],
            borderWidth: 2
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});
</script>

<script>
var ctx = document.getElementById('chartMachines').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['JAN', 'FEV', 'MAR', 'ABR', 'MAI', 'JUN', 'JUL', 'AGO', 'SET', 'OUT', 'NOV', 'DEZ'],
        datasets: [{
            label: 'Machines registration per month',
            data: <?= $graficDataMachines; ?> ,
            backgroundColor : [
                'rgba(75, 192, 192, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(75, 192, 192, 0.2)',
            ],
            borderColor: [
                'rgba(75, 192, 192, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(75, 192, 192, 1)',
            ],
            borderWidth: 2
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});
</script>

<script>
var ctx = document.getElementById('chartUsers').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['JAN', 'FEV', 'MAR', 'ABR', 'MAI', 'JUN', 'JUL', 'AGO', 'SET', 'OUT', 'NOV', 'DEZ'],
        datasets: [{
            label: 'Users registration per month',
            data: <?= $graficDataUsers; ?> ,
            backgroundColor : [
                'rgba(75, 192, 192, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(75, 192, 192, 0.2)',
            ],
            borderColor: [
                'rgba(75, 192, 192, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(75, 192, 192, 1)',
            ],
            borderWidth: 2
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});
</script>
@endpush
