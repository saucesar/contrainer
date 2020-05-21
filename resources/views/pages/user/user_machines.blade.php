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
              @include('pages/user/machine_table', ['machines' => $machines])
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-11 text-right" style="margin-left: 48px;">
    <button class="btn btn-primary btn-fab btn-round">
      <a href="{{ route('machines.create') }}">
        <i class="material-icons" style="color:white">add_to_queue</i>
      </a>
      @if(session('error'))
      <div class="alert alert-danger">{{ session('error') }}</div>
      @endif
    </button>
  </div>
</div>
@endsection

<style>
</style>