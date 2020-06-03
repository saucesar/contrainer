@extends('layouts.app', ['activePage' => 'user-machines', 'titlePage' => __("User's Machines")])

@section('content')
<div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title ">Show Machine</h4>
              <p class="card-category">show machine details</p>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                @include('pages.user.machine_show_form', ['machine' => $machine])
                <p>
                  {!! Form::open(['route' => ['machines.destroy', $machine], 'method' => 'delete']) !!}
                  <a href="{{ route('machines.edit', $machine) }}" class="btn btn-sm btn-outline-warning">
                      <i class="material-icons">create</i>
                  </a>
                  <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-sm btn-outline-danger">
                      <i class="material-icons">delete_sweep</i>
                  </button>
                  {!! Form::close() !!}
                </p>
              </div>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <h4 class="card-title ">Total Time In Activity {{ $machine->totalTimeActivity(2)}} hours</h4>
                <br>
                <h4 class="card-title ">Latest activity records</h4>
                  <table class='table'>
                    <thead>
                        <th>Id</th>
                        <th>DateTime Started</th>
                        <th>DateTime Ended</th>
                        <th>Time in activity</th>
                    </thead>
                    <tbody>
                        @foreach ($activities as $activity)
                          <tr>
                              <td>{{ $activity->id }}</td>
                              <td>{{ $activity->dataHoraInicio }}</td>
                              <td>
                                @if ($activity->dataHoraFim)
                                  {{ $activity->dataHoraFim }}
                                @else
                                  <div class="spinner-grow text-success" role="status">
                                    <span class="sr-only">Loading...</span>
                                  </div>
                                @endif
                              </td>
                              <td>{{ $activity->activityTime(2)}} hours</td>
                          </tr>
                        @endforeach
                    </tbody>
                </table>
                {!!$activities->links()!!}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
