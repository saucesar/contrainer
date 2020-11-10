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

var jsonViewerVolDriver = new JSONViewer();
document.querySelector("#volume-driver-json").appendChild(jsonViewerVolDriver.getContainer());
jsonViewerVolDriver.showJSON(<?= $volume_driver_json ?>, -1, 1);

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

            <div class="col-6">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title ">User Categories</h4>
                        <p class="card-category"><strong>Configure resource limits for each user category</strong></p>
                    </div>
                    <div class="card-body table table-responsive">
                        <div class="row">
                            <div class="col overflow-auto" style="height: 250px;">
                                <table class="table table-hover">
                                <thead class="thead-dark">
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>RAM Limit</th>
                                    <th>Storage Limit</th>
                                    <th>Options</th>
                                </thead>
                                <tbody>
                                @foreach($categories as $category)
                                <tr>
                                    <td>{{ $category->id }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->ram_limit }} MB</td>
                                    <td>{{ $category->storage_limit }} MB</td>
                                    <td class="td-actions">
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <button class="btn btn-sm btn-link btn-warning" data-toggle="modal"
                                                    data-target="#modalUserCategory{{ $category->id }}" title="Edit category">
                                                    <i class="material-icons">edit</i>
                                            </button>
                                            <form action="{{ route('user-categories.destroy', $category->id) }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-sm btn-link btn-danger" type="submit" onclick="return confirm('are you sure?');">
                                                    <i class="material-icons">delete</i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-success btn-link" data-toggle="modal"
                                data-target="#modalUserCategoryNew" title="New Category">
                                <i class="material-icons">add_circle_outline</i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-6">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title ">Volume Driver</h4>
                        <p class="card-category"><strong>Configure default volume driver to docker containers.</strong></p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col overflow-auto" style="height: 250px;">
                                <div id="volume-driver-json"></div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-warning btn-link" data-toggle="modal" data-target="#modalVolumeDriver"
                            title="Edit volume driver.">
                            <i class="material-icons">edit</i>
                        </button>
                    </div>
                </div>
            </div>

        </div>
        @include('pages.settings.modal_services_template')
        @include('pages.settings.modal_containers_template')
    </div>
    @include('pages.settings.modal_volume_driver')

    @foreach($categories as $category)
            @include('pages.settings.modal_user_category', [
                'route' => route('user-categories.update', $category->id),
                'category' => $category,
                'method' => 'PUT',
            ])
        @endforeach

        @include('pages.settings.modal_user_category', [
            'route' => route('user-categories.store'),
            'id' => 'New',
            'category' => null,
            'method' => 'POST',
        ])
</div>
@endsection