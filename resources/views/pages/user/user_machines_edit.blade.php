@extends('layouts.app', ['activePage' => 'user-machines', 'titlePage' => __("User's Machines")])

@section('content')
<div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title ">Edit Machine</h4>
              <p class="card-category">edit machine register</p>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                  @if($errors->any())
                    <div class="alert alert-danger">
                      <ul>
                          @foreach ($errors->all() as $error)
                              <li>{{$error}}</li>
                          @endforeach
                      </ul>
                    </div>
                  @endif
                  {!! Form::open(['route' => ['machines.update', $machine], 'method' => 'put']) !!}
                    @include('pages.user.machine_form',['selected_cpu' => $machine->cpu_utilizavel, 'selected_ram' => $machine->ram_utilizavel,])
                  {!! Form::close() !!}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection