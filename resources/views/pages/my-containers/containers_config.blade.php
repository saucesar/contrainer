@extends('layouts.app', ['activePage' => 'images', 'titlePage' => __("Containers")])

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
                        <div class="">
                            @include('pages.components.messages')
                            
                            {!! Form::open(['route' => 'containers.store', 'method' => 'post']) !!}
                            <input type="hidden" value="{{ $image->id }}" name='image_id'>
                            <input type="hidden" value="{{ $user_id }}" name='user_id'>
                            <h4 class="card-title">Image Selected : {{ $image->name }}</h4>
                            <br>

                            <div class="row">
                                <div class="col-sm-10">
                                    {!! Form::text('nickname', old('nickname'), ['class'=>"form-control", 'placeholder' =>"Nickname to container", 'required'=>"true"]) !!}
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-sm-10">
                                    {!! Form::text('envVariables', old('envVariables'), ['class'=>"form-control",
                                        'placeholder' =>"Environment variables (Optional) - Use ';' (semicolon) to separate, Ex: PASSWORD=password;POSTGRES_USER=user;"]) !!}
                                </div>
                                <div class="col-sm-10">
                                    {!! Form::text('Labels', old('Labels'), ['class'=>"form-control",
                                        'placeholder' =>"Labels (Optional) - Use ';' (semicolon) to separate, Ex: PASSWORD=password;POSTGRES_USER=user;"]) !!}
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-sm-1">
                                    <i class="material-icons">device_hub</i>
                                </div>
                                <div class="col-sm-9">
                                    {!! Form::text('Hostname', "", ['class'=>"form-control", 'placeholder' =>"Add a Hostname (Optional)"]) !!}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-1">
                                    <i class="material-icons">dns</i>
                                </div>
                                <div class="col-sm-4">
                                    {!! Form::text('Dns', "", ['class'=>"form-control", 'placeholder' =>"Set custom DNS server (Optional)"]) !!}
                                </div>
                                <div class="col-sm-1">
                                </div>
                                <div class="col-sm-4">
                                    {!! Form::text('DnsOptions', "", ['class'=>"form-control", 'placeholder' =>"Set custom DnsOptions (Optional)"]) !!}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-1">
                                </div>
                                <div class="col-sm-4">
                                    {!! Form::text('DnsSearch', "", ['class'=>"form-control", 'placeholder' =>"Set custom DnsSearch(Optional)"]) !!}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-1">
                                    <i class="material-icons">router</i>
                                </div>
                                <div class="col-sm-4">
                                    {!! Form::text('IPAddress', null, ['class'=>"form-control", 'placeholder' =>"Add a IPv4 (Optional)"]) !!}
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-sm-12">
                                    <a class = 'col-sm-1'><i class="material-icons">public</i></a>
                                    {{ Form::label('external-port-label', 'Add external communication port', ['class' => 'col-sm-4', 'for' => '#external-port']) }}
                                    {{ Form::checkbox('external-port', '-P', true, ['id' => 'external-port', 'class' => 'col-sm-2']) }}
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-sm-1">
                                    <i class="material-icons">router</i>
                                </div>
                                <div class="col-sm-4">
                                    {!! Form::text('MacAddress', "", ['class'=>"form-control", 'placeholder' => "Add a MacAddress (Optional)"]) !!}
                                </div>
                                <div class="col-sm-1">
                                    <i class="material-icons">router</i>
                                </div>
                                <div class="col-sm-4">
                                    {!! Form::text('Memory', 0, ['class'=>"form-control", 'placeholder' => "Add a Memory limite (Optional)"]) !!}
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-sm-1">
                                    <i class="material-icons">router</i>
                                </div>
                                <div class="col-sm-9">
                                    {!! Form::text('NetworkMode', "", ['class'=>"form-control", 'placeholder' => "Network mode. Supported values are: bridge, host, none, and container:<name|id>.(Optional)"]) !!}
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
