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
                        <h4 class="card-title ">Edit your container</h4>
                        <p class="card-category">Update the nickname</p>
                    </div>
                    <div class="card-body">
                        <div class="">
                            @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                                <button class="close alert-dismissible btn btn-link" data-dismiss="alert">
                                    <i class="material-icons">close</i>
                                </button>
                            </div>
                            @endif
                            @if(session('success'))
                            <div class="alert alert-success"role="alert">
                                {{ session('success') }}
                                <button class="close alert-dismissible btn btn-link" data-dismiss="alert">
                                    <i class="material-icons">close</i>
                                </button>
                            </div>
                            @endif
                            <div class="row">
                                <div class="col-sm-10">
                                    {!! Form::open(['route' => ['containers.update', $container->docker_id], 'method' => 'put']) !!}
                                        {!! Form::text('nickname',$container->nickname, ['class'=>"form-control", 'placeholder' =>"Nickname to container", 'required'=>"true"]) !!}
                                        <br>
                                        <div class="row">
                                            <div class="col-sm">
                                                <button type="submit" class="btn btn-primary">Save</button>
                                            </div>
                                        </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
