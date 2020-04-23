@extends('layouts.app', ['activePage' => 'user-container', 'titlePage' => __("Avaiable Container")])

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
                  <a href="{{ route('containers.create') }}">
                    <i class="material-icons">queue</i>
                    Add New
                  </a>
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
                          <th>Programs</th>
                          @if ($isAdmin)
                            <th>Command</th>
                          @endif
                          <th>Options</th>
                      </thead>
                      <tbody>
                          @foreach ($containers as $container)
                            <tr>
                              <td>{{ $container->name }}</td>
                              <td>{{ $container->description }}</td>
                              <td>{{ $container->programs }}</td>
                              @if ($isAdmin)
                                <td>{{ $container->command }}</td>
                              @endif
                              <td>
                                <div class='row'>
                                  {!! Form::open(['route' => ['containers.instaciate', $container], 'method' => 'post']) !!}
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                      <i class="material-icons">queue</i>
                                      Create
                                    </button>
                                  {!! Form::close() !!}
                                  @if ($isAdmin)
                                    <a href="{{ route('containers.edit', $container) }}" class="btn btn-sm btn-outline-warning">
                                      <i class="material-icons">create</i>
                                    </a>
                                    {!! Form::open(['route' => ['containers.destroy', $container], 'method' => 'delete']) !!}
                                      <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="material-icons">delete_sweep</i>
                                      </button>
                                    {!! Form::close() !!}
                                  @endif
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