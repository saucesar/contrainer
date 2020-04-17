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
                  @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                  @endif
                  <table class='table'>
                      <thead>
                          <th>Id</th>
                          <th>Description</th>
                          <th>Programs</th>
                          <th></th>
                      </thead>
                      <tbody>
                          @foreach ($containers as $container)
                            <td>{{ $container->id }}</td>
                            <td>{{ $container->description }}</td>
                            <td>{{ $container->programs }}</td>
                            <td>
                              <a href="#">
                                <i class="material-icons">queue</i>
                                Instantiate
                              </a>
                            </td>
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