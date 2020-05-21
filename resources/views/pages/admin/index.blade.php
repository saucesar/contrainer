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
              <p class="card-category">Registered Machines</p>
              <h3 class="card-title">{{ $numberOfMach }}</h3>
              <div class="collapse card-title" id="machine-details">
                <br>
                <p>Active: {{ $inActivity }}</p>
                <a href="{{ route('admin.area.machines') }}" class="btn btn-warning">full list</a>
              </div>
            </div>
            <div class="card-footer">
                <a rel="tooltip" class="btn btn-link" data-toggle="collapse" data-target="#machine-details" aria-expanded="false" aria-controls="collapseExample">
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
              <p class="card-category">Registered Users</p>
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
                <a rel="tooltip" class="btn btn-link" data-toggle="collapse" data-target="#users-details" aria-expanded="false" aria-controls="collapseExample">  
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
              <p class="card-category">Container Images</p>
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
                <a rel="tooltip" class="btn btn-link" data-toggle="collapse" data-target="#container-details" aria-expanded="false" aria-controls="collapseExample">  
                    <i class="material-icons">expand_more</i>
                    More Details
                </a>
            </div>
          </div>
        </div>

      </div>

      <div class="row">

        <div class="col-md-4">
          <div class="card card-chart">
            <div class="card-header card-header-success">
              <div class="ct-chart" id="dailySalesChart"></div>
            </div>
            <div class="card-body">
              <h4 class="card-title">Daily Sales</h4>
              <p class="card-category">
                <span class="text-success"><i class="fa fa-long-arrow-up"></i> 55% </span> increase in today sales.</p>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons">access_time</i> updated 4 minutes ago
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card card-chart">
            <div class="card-header card-header-warning">
              <div class="ct-chart" id="websiteViewsChart"></div>
            </div>
            <div class="card-body">
              <h4 class="card-title">Email Subscriptions</h4>
              <p class="card-category">Last Campaign Performance</p>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons">access_time</i> campaign sent 2 days ago
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card card-chart">
            <div class="card-header card-header-danger">
              <div class="ct-chart" id="completedTasksChart"></div>
            </div>
            <div class="card-body">
              <h4 class="card-title">Completed Tasks</h4>
              <p class="card-category">Last Campaign Performance</p>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons">access_time</i> campaign sent 2 days ago
              </div>
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
@endpush