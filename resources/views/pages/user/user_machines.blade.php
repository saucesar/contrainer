@extends('layouts.app', ['activePage' => 'user-machines', 'titlePage' => __("User's Machines")])

@section('content')
<div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title ">Machines Table</h4>
              <p class="card-category">List of {{ $user_name }} machines</p>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                  <a href="{{ route('machines.create') }}">
                      <i class="material-icons">queue</i>
                      Add New
                  </a>
                  @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                  @endif
                  <table class='table'>
                      <thead>
                          <th>Hashcode</th>
                          <th>CPU/RAM Available</th>
                          <th>Running</th>
                          <th>Options</th>
                      </thead>
                      <tbody>
                          @foreach ($machines as $machine)
                            <tr>
                                <td>{{ $machine->hashcode }}</td>
                                <td>
                                  {{ $machine->cpu_utilizavel }}%
                                  <span>/</span>
                                  {{ $machine->ram_utilizavel }}MB
                                </td>
                                <td>
                                  @if($machine->disponivel)
                                    <div class="spinner-grow text-success" role="status">
                                      <span class="sr-only">Loading...</span>
                                    </div>
                                  @else
                                    Stopped
                                  @endif
                                </td>
                                <td>
                                  <div class='content'>
                                    <div class='conteiner-fluid'>
                                      <div class='row'>
                                        <button class="btn btn-sm btn-outline-info" type="button" data-toggle="collapse" data-target="#{{ $machine->id }}" aria-expanded="false" aria-controls="collapseExample">
                                          <i class="material-icons">remove_red_eye</i>
                                        </button>
                                        <a href="{{ route('machines.edit', $machine) }}" class="btn btn-sm btn-outline-warning">
                                          <i class="material-icons">create</i>
                                        </a>
                                        {!! Form::open(['route' => ['machines.destroy', $machine], 'method' => 'delete']) !!}
                                          <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="material-icons">delete_sweep</i>
                                          </button>
                                        {!! Form::close() !!}
                                      </div>
                                    </div>
                                  </div>
                                </td>
                            </tr>
                            <tr>
                              <td>
                                <div class="collapse" id="{{ $machine->id }}">
                                  @include('pages.user.machine_show_form', ['machine' => $machine])
                                  <a href="{{ route('machines.show', $machine) }}" class="btn btn-sm btn-outline-info">
                                    More Details
                                  </a>
                                  <button class="btn btn-sm btn-outline" type="button" data-toggle="collapse" data-target="#{{ $machine->id }}" aria-expanded="false" aria-controls="collapseExample">
                                    Ocult
                                  </button>
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