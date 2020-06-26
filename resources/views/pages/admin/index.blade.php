@extends('layouts.app', ['activePage' => 'admin-area', 'titlePage' => __("Admin Area")])

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">

            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">album</i>
                        </div>
                        <p class="card-category">Instances</p>
                        <h3 class="card-title">{{ $images->count() }}</h3>
                        <div class="collapse card-title" id="container-details">
                            <table class='table'>
                                <thead>
                                    <th>Image</th>
                                    <th>Instances</th>
                                </thead>
                                <tbody>
                                    @foreach($images as $image)
                                    <tr>
                                        <td>{{ $image->name }}</td>
                                        <td>{{ $instacesOfeachImage[$image->id] }}</td>
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

        <div class="row">
            <div class="col-lg-12">
                <div class="card card-stats">
                    <div class="card-header card-header-info">
                        <h3 class="card-title">
                            <i class="material-icons">laptop</i>
                            Machines List
                        </h3>
                        <p class="card-category"></p>
                    </div>
                    <div class="" id="machines">
                        @include('pages/tables/machine_table', ['machines' => $machines])
                    </div>
                    <div class="card-footer">
                        <p class="card-category">In Activity: {{ $inActivity }}</p>
                        <p class="card-category">Total: {{ $numberOfMach }}</p>
                        <p class="card-category"></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card card-stats">
                    <div class="card-header card-header-info">

                        <h3 class="card-title">
                            <i class="material-icons">people</i>
                            Users List
                        </h3>
                        <p class="card-category"></p>
                    </div>
                    <div class="" id="users">
                        @include('pages/tables/users_table', ['users' => $users])
                    </div>
                    <div class="card-footer">
                        <p class="card-category">Registered this Mouth: {{ $registeredMonth }}</p>
                        <p class="card-category">Registered Today: {{ $registeredToday }}</p>
                        <p class="card-category">Total: {{ $users->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card card-stats">
                    <div class="card-header card-header-info">

                        <h3 class="card-title">
                            <i class="fab fa-docker"></i>
                            Images List
                        </h3>
                        <p class="card-category"></p>
                    </div>
                    <div class="" id="images">
                        @include('pages/tables/images_table', ['images' => $images, 'user_id' => '', 'isAdmin' => $isAdmin])
                    </div>
                    <div class="card-footer">
                        <p class="card-category"></p>
                        <p class="card-category">Total:{{ $images->count() }}</p>
                        <p class="card-category"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    var
</script>
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
