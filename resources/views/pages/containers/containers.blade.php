@extends('layouts.app', ['activePage' => 'user-container', 'titlePage' => __("Containers")])

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
              <div class="">
                  @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                  @endif
                  @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                  @endif
                  @include('pages/tables/images_table', ['containers' => $containers, 'user_id' => $user_id])
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-11 text-right" style="margin-left: 48px;">
      @if ($isAdmin)
        <button class="btn btn-primary btn-fab btn-round">
          <a href="{{ route('containers.create') }}">
            <i class="material-icons" style="color:white">add_to_queue</i>
          </a>
          @if(session('error'))
          <div class="alert alert-danger">{{ session('error') }}</div>
          @endif
        </button>
      @endif
    </div>
  </div>
@endsection
