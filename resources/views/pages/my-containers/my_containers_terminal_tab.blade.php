@extends('layouts.app', ['activePage' => 'my-containers', 'titlePage' => __("Container name: $mycontainer->nickname")])

@section('content')
<div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title ">Container Terminal Tab</h4>
              <p class="card-category">Command to container {{ $mycontainer->nickname }}</p>
            </div>
            <div class="card-body" style="background: gray;">
              <div class="table-responsive">
                  @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                  @endif
                  @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                  @endif
                <div id="{{ $mycontainer->id }}">
                    @include('pages.my-containers.my_containers_show', ['mycontainer' => $mycontainer, 'consoleOuts' => $outs, 'newTab' => true])
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection