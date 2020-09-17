@extends('layouts.app', ['activePage' => 'my-containers', 'titlePage' => __("My Containers")])

@push('js')
@endpush

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title ">Containers Table</h4>
                        <p class="card-category">List of Instace Container Images</p>
                    </div>
                    <div class="card-body">
                        @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>                                    
                        </div>
                        @endif
                        @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                        @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @include('pages/tables/containers_table', ['$mycontainers' => $mycontainers, 'isAdminArea' => false])
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-11 text-right" style="margin-left: 48px;">
        <button class="btn btn-primary btn-fab btn-round" data-toggle="modal" data-target="#modalContainers">
            <i class="material-icons" style="color:white">add_to_queue</i>
        </button>
        @include('pages/my-containers/modal_containers')
    </div>
</div>
@endsection
