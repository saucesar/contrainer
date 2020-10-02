@extends('layouts.app', ['activePage' => 'settings', 'titlePage' => __("Settings"), 'title' => __("Settings")])

@push('js')
<script>
function changeIcon(element) {
    $(element).find('i').toggleClass('fas fa-minus');
}

var jsonViewerService = new JSONViewer();
document.querySelector("#services-json").appendChild(jsonViewerService.getContainer());
jsonViewerService.showJSON(<?= $service_template_json ?>, -1, 1);

var jsonViewerContainer = new JSONViewer();
document.querySelector("#containers-json").appendChild(jsonViewerContainer.getContainer());
jsonViewerContainer.showJSON(<?= $container_template_json ?>, -1, 1);
</script>
@endpush

@section('content')
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-12">
                @include('pages.components.messages')
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title ">Services Template</h4>
                        <p class="card-category"><strong>Configure default template to create services</strong></p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col overflow-auto" style="height: 250px;">
                                <div id="services-json"></div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-warning btn-link" data-toggle="modal" data-target="#modalServices"
                            title="Edit services template">
                            <i class="material-icons">edit</i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title ">Containers Template</h4>
                        <p class="card-category"><strong>Configure default params to the create containers</strong></p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col overflow-auto" style="height: 250px;">
                                <div id="containers-json"></div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-warning btn-link" data-toggle="modal" data-target="#modalContainersService"
                            title="Edit containers template">
                            <i class="material-icons">edit</i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @include('pages.settings.modal_services_template')
        @include('pages.settings.modal_containers_template')
    </div>
</div>
@endsection