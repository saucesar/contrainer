@extends('layouts.app', ['activePage' => 'dashboard', 'titlePage' => __('Dashboard')])

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row"><!--
            @foreach($machines as $machine)
            <div class="col-lg-6 col-md-12 col-sm-12" style="zoom: 90%;">
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
                    </div>
                    <div class='card-body'>
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
                            <a rel="tooltip" class="btn btn-link" data-toggle="collapse" data-target="#{{ $machine->id }}"aria-expanded="false">
                                <i class="material-icons">import_export</i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach-->
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
                    <div class="card-body">
                        <div class="td-actions d-flex justify-content-center">
                            <div class='row text-rigth'>
                                <a href="{{ route('container.terminalTab', $container->docker_id) }}" class="btn btn-info btn-link"
                                    target="_black" title="Open terminal.">
                                    <i class="fas fa-terminal"></i>
                                </a>
                                <a href="{{ route('containers.show' , [$container->docker_id]) }}" class="btn btn-link"
                                    title="Details.">
                                    <i class="material-icons">visibility</i>
                                </a>
                                <a href="{{ route('containers.edit' , [$container->docker_id]) }}" class="btn btn-warning btn-link"
                                    title="Edit nickname.">
                                    <i class="material-icons">edit</i>
                                </a>
                                {!! Form::open(['route' => ['containers.destroy', $container->docker_id], 'method' => 'delete']) !!}
                                <button type="submit" class="btn btn-danger btn-link" title="Detele the container."
                                    onclick="return confirm('Are you sure?')" type="submit">
                                    <i class="material-icons">delete</i>
                                </button>
                                {!! Form::close() !!}
                            </div>
                        </div>
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
