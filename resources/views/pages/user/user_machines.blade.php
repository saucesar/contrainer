@extends('layouts.app', ['activePage' => 'user-machines', 'titlePage' => __("User's Machines")])

@section('content')
<div class="content" style="zoom: 85%;">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title ">Machines Table</h4>
            <p class="card-category">List of {{ $user_name }}' machines</p>
          </div>
          <div class="card-body">
            @if(session('error'))
              <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <div class="">
              @include('pages/tables/machine_table', ['machines' => $machines])
              @include('pages.my-containers.machines_modal')
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-11 text-right" style="margin-left: 48px;">
    <button class="btn btn-primary btn-fab btn-round"  data-toggle="modal" data-target="#machineModal">
        <i class="material-icons" style="color:white">add_to_queue</i>
    </button>
  </div>
</div>
@endsection
