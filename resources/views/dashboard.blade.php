@extends('layouts.app', ['activePage' => 'dashboard', 'titlePage' => __('Dashboard')])

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            @foreach($machines as $machine)
            <div class="col-lg-6 col-md-12 col-sm-12">
                <div class="card card-stats">
                    <div class="card-header card-header-danger card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">computer</i>
                        </div>
                        <p class="card-category"></p>
                        <h3 class="card-title">
                            {{ $machine->ram_utilizavel }} MB
                            <i class="fas fa-memory" title='Avaiable RAM'></i>
                        </h3>
                        <h3 class="card-title">
                            {{ $machine->cpu_utilizavel }}%
                            <i class="fas fa-microchip" title='Avaiable CPU'></i>
                        </h3>
                        <h3 class="card-title">
                            {{ $machine->ip }}
                            <i class="fas fa-network-wired" title='IP Address'></i>
                        </h3>
                        <div class="collapse" id="{{ $machine->id }}">
                            <h3 class="card-title">
                                {{ $machine->created_at }}
                                <i class="material-icons" title='Created At'>date_range</i>
                            </h3>
                            <h3 class="card-title">
                                {{ $machine->totalTimeActivity(2) }} Hrs
                                <i class="fas fa-stopwatch" title="Total Time in Activity"></i>
                            </h3>
                        </div>

                    </div>
                    <div class="card-footer">
                        <div class="stats" title="Hashcode">
                            <i class="material-icons">vpn_key</i>
                            {{ $machine->hashcode }}
                        </div>
                        <a rel="tooltip" class="btn btn-link" data-toggle="collapse" data-target="#{{ $machine->id }}"
                            aria-expanded="false">
                            <i class="material-icons">import_export</i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="row">
            @foreach($containers as $container)
            <div class="col-lg-6 col-md-12 col-sm-12">
                <div class="card card-stats">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="fas fa-server"></i>
                        </div>
                        <p class="card-category"></p>
                        <h3 class="card-title">
                            {{ $container->nickname }}
                            <i class="fas fa-server" title="Nickname"></i>
                        </h3>
                        <h3 class="card-title">
                            {{ $container->image()->name }}
                            <i class="fab fa-docker" title="Docker Image Used"></i>
                        </h3>
                        <h3 class="card-title">
                            {{ $container->created_at }}
                            <i class="material-icons" title='Created At'>date_range</i>

                        </h3>
                    </div>
                    <div class="card-footer" title="Container Id">
                        <div class="stats">
                            <i class="material-icons">vpn_key</i>
                            {{ $container->docker_id }}
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
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
