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
                        <h4 class="card-title ">Configure Your Container</h4>
                        <p class="card-category">Add parameters before initializing your container</p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif
                            @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                            @endif
                            {!! Form::open(['route' => 'InstanciaContainers.store', 'method' => 'post']) !!}
                            <input type="hidden" value="{{ $container->id }}" name='image_id'>
                            <input type="hidden" value="{{ $userId }}" name='user_id'>
                            <h4 class="card-title">Image Selected : {{ $container->name }}</h4>
                            <br>

                            <div class="row">
                                <div class="col-sm-10">
                                    {!! Form::text('nickname', null, ['class'=>"form-control", 'placeholder' =>"Nickname to container", 'required'=>"true"]) !!}
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-sm-10">
                                    {!! Form::text('envVariables', null, ['class'=>"form-control",
                                        'placeholder' =>"Environment variables (Optional) - Use ';' (semicolon) to separate, Ex: PASSWORD=password;POSTGRES_USER=user;"]) !!}
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-sm-1">
                                    <i class="material-icons">device_hub</i>
                                </div>
                                <div class="col-sm-4">
                                    {!! Form::text('add-host', null, ['class'=>"form-control", 'placeholder' =>"Add a host (Optional)"]) !!}
                                </div>
                                <div class="col-sm-1">
                                    <i class="material-icons">dns</i>
                                </div>
                                <div class="col-sm-4">
                                    {!! Form::text('dns', null, ['class'=>"form-control", 'placeholder' =>"Set custom DNS servers (Optional)"]) !!}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-1">
                                    <i class="material-icons">router</i>
                                </div>
                                <div class="col-sm-4">
                                    {!! Form::text('ip', null, ['class'=>"form-control", 'placeholder' =>"Add a IPv4 (Optional)"]) !!}
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-sm">
                                    {{ Form::checkbox('external-port', '-P', true, ['id' => 'external-port']) }}
                                    {{ Form::label('external-port-label', 'Add external communication port', ['for' => 'external-port']) }}
                                    <a><i class="material-icons">public</i></a>
                                </div>
                            </div>
                            <br>
                            <button type="submit" class="btn btn-success">
                                <i class="material-icons">archive</i>
                                Confirme
                            </button>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection