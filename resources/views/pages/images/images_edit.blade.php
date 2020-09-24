@extends('layouts.app', ['activePage' => 'images', 'titlePage' => __("Avaiable image")])

@push('js')
@endpush

@section('content')
<div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title ">Images Table</h4>
              <p class="card-category">Edit Image</p>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                  {!! Form::open(['route' => ['images.update', $image], 'method' => 'put']) !!}
                    @include('pages/images/images_form', ['image' => $image])
                  {!! Form::close() !!}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
