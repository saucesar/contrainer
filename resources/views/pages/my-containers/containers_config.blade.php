@extends('layouts.app', ['activePage' => 'images', 'titlePage' => __("Containers")])

@push('js')
<script type="text/javascript" src="{{ asset('js') }}/cloud.js"></script>
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
                        @include('pages.components.messages')
                        <div class="">
                            {!! Form::open(['route' => 'containers.store', 'method' => 'post']) !!}
                            <div class="text-left">
                                <div class="row">
                                    <div class="col-sm-5">
                                        {!! Form::text('nickname', old('nickname'), ['class'=>"form-control", 'placeholder' => "Nickname to container", 'required'=>"true"]) !!}
                                    </div>
                                    <div class="col-sm-5">
                                        <select name="image_id" class='form-control' required>
                                            <option value="">Select a Image</option>
                                            @foreach($images as $image)
                                            <option value="{{ $image->id }}" {{ old('image_id') == $image->id ? 'selected' : '' }}>{{ $image->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <br>
                                @include('pages/settings/container_form')
                            </div>
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
