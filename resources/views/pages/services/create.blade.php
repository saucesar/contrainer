@extends('layouts.app', ['activePage' => 'services', 'titlePage' => __("Services"), 'title' => __("Services")])

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title ">Services</h4>
                        <p class="card-category">New Service</p>
                    </div>
                    <div class="card-body table-responsive">
                        <div class="container-fluid" id="grad1">
                            <div class="row justify-content-center mt-0">
                                <div class="coltext-center p-0 mt-3 mb-2">
                                    <div class="">
                                        <h2><strong>Follow the Steps to Create a Service</strong></h2>
                                        <p>Fill de required params</p>
                                        @include('pages.components.messages')

                                        <div class="row">
                                            <div class="col">
                                                <form id="regForm" action="{{ route('services.store') }}" method="{{'POST'}}">
                                                    @csrf
                                                    @include('pages.services.form')
                                                </form>
                                            </div>
                                        </div>
                                    </div>
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

@push('js')
<script src="{{ asset('js') }}/steps.js" type="text/javascript"></script>
@endpush