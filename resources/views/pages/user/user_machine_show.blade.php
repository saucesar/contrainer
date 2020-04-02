@extends('layouts.app', ['activePage' => 'user-machines', 'titlePage' => __("User's Machines")])

@section('content')
<div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title ">Show Machine</h4>
              <p class="card-category">show details of machine</p>
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

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection