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
                              <td>{{ substr($container->container_docker_id, 0, 10  ) }}</td>  
                              <td>{{ $container->nickname }}</td>
                              <td>{{ $container->dataHora_instanciado }}</td>
                              <td>
                                  @if ($container->dataHora_finalizado)
                                    Stoped
                                  @else
                                    <div class="spinner-grow text-success" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                  @endif
                              </td>
                              <td class="td-actions text-right">
                                <div class='row'>
                                  @if($container->dataHora_finalizado)
                                  <a href="{{ route('instance.playStop', $container->container_docker_id) }}" class="btn btn-success" data-original-title="" title="">
                                    <i class=" material-icons">play_circle_outline</i>
                                  </a>
                                  @else
                                  <a href="{{ route('instance.playStop', $container->container_docker_id) }}" class="btn btn-warning" data-original-title="" title="">
                                    <i class=" material-icons">pause_circle_outline</i>
                                  </a>
                                  @endif

                                  <a rel="tooltip" class="btn btn-success btn-link" data-toggle="collapse" data-target="#{{ $container->id }}" aria-expanded="false" aria-controls="collapseExample">
                                      <i class="material-icons">details</i>
                                      <div class="ripple-container"></div>
                                    </a>
                                    <a href="#" class="btn btn-warning btn-link">
                                      <i class="material-icons">edit</i>
                                    </a>
                                  {!! Form::open(['route' => ['InstanciaContainers.destroy', $container], 'method' => 'delete']) !!}
                                    <button type="submit" class="btn btn-danger btn-link" data-original-title="" title="" onclick="return confirm('Are you sure?')" type="submit">
                                        <i class="material-icons">delete</i>
                                    </button>
                                  {!! Form::close() !!}
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td colspan='6'>
                                <div class="collapse card-header" style="background: gray;" id="{{ $container->id }}">
                                  @include('pages.my-containers.my_containers_show', ['mycontainer' => $container, 'consoleOuts' => $consoleOuts])
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