@extends('layouts.app', ['activePage' => 'admin-area', 'titlePage' => __("Admin Area")])

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title ">Machines List</h4>
            <p class="card-category">List of registered machines</p>
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
</div>
@endsection
