@extends('layouts.app', ['activePage' => 'user-container', 'titlePage' => __("Containers")])

@push('js')
@endpush

@section('content')
<div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title ">Container Images Table</h4>
              <p class="card-category">List of Available Container Images</p>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                  @if ($isAdmin)
                    <a href="{{ route('containers.create') }}">
                      <i class="material-icons">queue</i>
                      Add New
                    </a>
                  @endif
                  @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                  @endif
                  @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                  @endif
                  <table class='table'>
                      <thead>
                          <th>Name</th>
                          <th>Description</th>
                          <th>Options</th>
                      </thead>
                      <tbody>
                          @foreach ($containers as $container)
                            <tr>
                              <td>{{ $container->name }}</td>
                              <td width='600px'>{{ $container->description }}</td>
                              <td class="td-actions text-right">
                                <div class='row'>
                                  {!! Form::open(['route' => ['InstanciaContainers.store', $container], 'method' => 'post']) !!}
                                    <input type="hidden" value="{{ $container->id }}" name='id'>
                                    <button type="submit" class="btn btn-sucess btn-link">
                                      <i class="material-icons">queue</i>
                                      Use
                                    </button>
                                  {!! Form::close() !!}
                                  @if ($isAdmin)
                                    <a rel="tooltip" class="btn btn-success btn-link" data-toggle="collapse" data-target="#{{ $container->id }}" aria-expanded="false" aria-controls="collapseExample">
                                      <i class="material-icons">details</i>
                                      <div class="ripple-container"></div>
                                    </a>
                                    <a href="{{ route('containers.edit', $container) }}" class="btn btn-warning btn-link">
                                      <i class="material-icons">edit</i>
                                    </a>
                                    {!! Form::open(['route' => ['containers.destroy', $container], 'method' => 'delete']) !!}
                                      <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-danger btn-link">
                                        <i class="material-icons">delete_sweep</i>
                                      </button>
                                    {!! Form::close() !!}
                                  @endif
                                </div>
                              </td>
                              </tr>
                              <tr>
                                <td></td>
                                <td>
                                  <div class="collapse" id="{{ $container->id }}">
                                    @include('pages.containers.containers_show_form', ['container' => $container, 'isAdmin' => $isAdmin])
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
  </div>
@endsection