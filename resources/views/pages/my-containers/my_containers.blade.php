@extends('layouts.app', ['activePage' => 'my-containers', 'titlePage' => __("My Containers")])

@push('js')
@endpush

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title ">Containers Table</h4>
                        <p class="card-category">List of Instace Container Images</p>
                    </div>
                    <div class="card-body">
                        @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                        @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        <table class='table'>
                            <thead>
                                <th>#</th>
                                <th>Container Id</th>
                                <th>Nickname</th>
                                <th>Iniciated at</th>
                                <th>Running</th>
                                <th>Options</th>
                            </thead>
                            <tbody>
                                @foreach ($mycontainers as $container)
                                <tr>
                                    <td><i class="fas fa-box"></i></td>
                                    <td>{{ substr($container->docker_id, 0, 12) }}</td>
                                    <td>{{ $container->nickname }}</td>
                                    <td>{{ $container->dataHora_instanciado }}</td>
                                    <td class="td-actions text-center">
                                        @if ($container->dataHora_finalizado)
                                        <a href="#" class="btn btn-danger" data-original-title="" title="">
                                            <i class=" material-icons">stop</i>
                                        </a>
                                        @else
                                        <div class="spinner-grow text-success" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                        @endif
                                    </td>
                                    <td class="td-actions text-right">
                                        <div class='row'>
                                            @if($container->dataHora_finalizado)
                                            <a href="{{ route('instance.playStop', $container->docker_id) }}"
                                                class="btn btn-link btn-success" data-original-title=""
                                                title="Play/Pause the container.">
                                                <i class=" material-icons">play_circle_outline</i>
                                            </a>
                                            @else
                                            <a href="{{ route('instance.playStop', $container->docker_id) }}"
                                                class="btn btn-link btn-warning" data-original-title=""
                                                title="Play/Pause the container.">
                                                <i class=" material-icons">pause_circle_outline</i>
                                            </a>
                                            @endif
                                            <a href="{{ route('container.terminalTab', $container->docker_id) }}"
                                                class="btn btn-info btn-link" target="_black" title="Open terminal.">
                                                <i class="fas fa-terminal"></i>
                                            </a>
                                            <a href="{{$dockerHost}}/containers/{{$container->docker_id}}/export"
                                                class="btn btn-link" title="Download.">
                                                <i class=" material-icons">get_app</i>
                                            </a>
                                            <a href="{{ route('mycontainers.show' , [$container->docker_id]) }}"
                                                class="btn btn-link" title="Details.">
                                                <i class="material-icons">error</i>
                                            </a>
                                            <a href="{{$dockerHost}}/containers/{{$container->docker_id}}/logs?timestamps=1&stdout=1&stderr=1"
                                                class="btn btn-link" target="_black" title="Logs.">
                                                <i class="fas fa-file-alt"></i>
                                            </a>
                                            {!! Form::open(['route' => ['InstanciaContainers.destroy',
                                            $container->docker_id], 'method' => 'delete']) !!}
                                            <button type="submit" class="btn btn-danger btn-link"
                                                title="Detele the container." onclick="return confirm('Are you sure?')"
                                                type="submit">
                                                <i class="material-icons">delete</i>
                                            </button>
                                            {!! Form::close() !!}
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-11 text-right" style="margin-left: 48px;">
        <button class="btn btn-primary btn-fab btn-round">
            <a href="{{ route('images.index') }}">
                <i class="material-icons" style="color:white">add_to_queue</i>
            </a>
        </button>
    </div>
</div>
@endsection
