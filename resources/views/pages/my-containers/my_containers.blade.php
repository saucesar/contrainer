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
                        <h4 class="card-title ">Containers Instance Table</h4>
                        <p class="card-category">List of Instace Container Images</p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif
                            @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                            @endif
                            <table class='table'>
                                <thead>
                                    <th>Machine Hashcode</th>
                                    <th>Container Id</th>
                                    <th>Nickname</th>
                                    <th>Iniciated at</th>
                                    <th>Running</th>
                                    <th>Options</th>
                                </thead>
                                <tbody>
                                    @foreach ($mycontainers as $container)
                                    <tr>
                                        <td>{{ substr($container->hashcode_maquina, 0, 10) }} ...</td>
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
                                                <a href="{{ route('instance.playStop', $container->docker_id) }}" class="btn btn-link btn-success" data-original-title="" title="Play/Pause this container.">
                                                    <i class=" material-icons">play_circle_outline</i>
                                                </a>
                                                @else
                                                <a href="{{ route('instance.playStop', $container->docker_id) }}" class="btn btn-link btn-warning" data-original-title="" title="Play/Pause this container.">
                                                    <i class=" material-icons">pause_circle_outline</i>
                                                </a>
                                                @endif
                                                <a href="{{$dockerHost}}/containers/{{$container->docker_id}}/export" class="btn btn-link" title="Download your container.">
                                                    <i class=" material-icons">get_app</i>
                                                </a>
                                                <a rel="tooltip" class="btn btn-success btn-link" data-toggle="collapse" data-target="#{{ $container->id }}" aria-expanded="false" title="Show console.">
                                                    <i class="material-icons">details</i>
                                                </a>
                                                <a href="{{ route('containers.show' , [$container->docker_id]) }}" class="btn btn-link" title="Container details page.">
                                                    <i class="material-icons">error</i>
                                                </a>
                                                {!! Form::open(['route' => ['InstanciaContainers.destroy',
                                                $container->docker_id], 'method' => 'delete']) !!}
                                                <button type="submit" class="btn btn-danger btn-link" title="Detele this container." onclick="return confirm('Are you sure?')" type="submit">
                                                    <i class="material-icons">delete</i>
                                                </button>
                                                {!! Form::close() !!}
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan='6'>
                                            <div class="collapse card-header" style="background: gray;" id="{{ $container->id }}">
                                                @include('pages.my-containers.my_containers_show', ['mycontainer' => $container, 'consoleOuts' => $consoleOuts, 'newTab' => false])
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
    </div>
    <div class="col-lg-11 text-right" style="margin-left: 48px;">
        <button class="btn btn-primary btn-fab btn-round">
            <a href="{{ route('containers.index') }}">
                <i class="material-icons" style="color:white">add_to_queue</i>
            </a>
        </button>
    </div>
</div>
@endsection
