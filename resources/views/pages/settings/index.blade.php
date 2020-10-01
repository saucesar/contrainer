@extends('layouts.app', ['activePage' => 'settings', 'titlePage' => __("Settings"), 'title' => __("Settings")])

@push('js')
<script>
function changeIcon(element) {
    $(element).find('i').toggleClass('fas fa-minus');
}

var jsonViewerService = new JSONViewer();
document.querySelector("#services-json").appendChild(jsonViewerService.getContainer());
jsonViewerService.showJSON(<?= $service_template_json ?>, -1, 1);
</script>
@endpush

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title ">Settings</h4>
                        <p class="card-category">Configure default params to the plataform</p>
                    </div>
                    <div class="card-body">
                        <div class="">
                            @include('pages.components.messages')
                            <div class="row d-flex justify-content-center">
                                <div class="col-6">
                                    <h3>
                                        Service Template
                                        <button class="btn btn-warning btn-link w-25" data-toggle="modal"
                                            data-target="#modalServices" title="Edit services template">
                                            <i class="material-icons">edit</i>
                                        </button>
                                    </h3>
                                </div>
                            </div>
                            <div class="row d-flex justify-content-center">
                                <div class="col-6">
                                    <div id="services-json"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('pages.settings.modal_services_template')
    </div>
</div>
@endsection