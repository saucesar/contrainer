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
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection