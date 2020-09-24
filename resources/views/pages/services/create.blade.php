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
                                <div class="col-11 col-sm-9 col-md-7 col-lg-6 text-center p-0 mt-3 mb-2">
                                    <div class="card px-0 pt-4 pb-0 mt-3 mb-3">
                                        <h2><strong>Follow the Steps to Create a Service</strong></h2>
                                        <p>Fill de required params</p>
                                        @include('pages.components.messages')

                                        <div class="row">
                                            <div class="col-md-12 mx-0">
                                                <form id="msform" action="{{ route('services.store') }}" method="{{'POST'}}">
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