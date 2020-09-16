@extends('layouts.app', ['activePage' => 'services', 'titlePage' => __("Services"), 'title' => __("Services")])

@push('js')
@endpush

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title ">Services</h4>
                        <p class="card-category">Your Services</p>
                    </div>
                    <div class="card-body table-responsive">
                        <div class="">
                            @if(isset($error))
                            <div class="alert alert-danger">
                                {{ $error }}
                                <button class="close alert-dismissible btn btn-link" data-dismiss="alert">
                                    <i class="material-icons">close</i>
                                </button>
                            </div>
                            @endif
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
                            @if(count($services) == 0)
                                <h3>No Services Found</h3>
                            @else
                            <table class="table table-bordered table-hover table-responsive text-center">
                                <thead class="thead-light">
                                    <tr>
                                        <th rowspan="2">Name</th>
                                        <th rowspan="2">Image</th>
                                        <th rowspan="2">Replicas</th>
                                        <th colspan="3">Ports</th>
                                        <th colspan="3" rowspan="2">Options</th>
                                    </tr>
                                    <tr>
                                        <td colspan="1">Protocol</td>
                                        <td colspan="1">Target</td>
                                        <td colspan="1">Published</td>
                                    </tr>
                                </thead>
                                @foreach($services as $service)
                                <tbody>
                                    <tr>
                                        <td scope="col"
                                            rowspan="{{ isset($service['Spec']['EndpointSpec']['Ports']) ? count($service['Spec']['EndpointSpec']['Ports'])*2 : 2 }}">
                                            {{ $service['Spec'] ? $service['Spec']['Name'] : ''}}
                                        </td>
                                        <td scope="col"
                                            rowspan="{{ isset($service['Spec']['EndpointSpec']['Ports']) ? count($service['Spec']['EndpointSpec']['Ports'])*2 : 2 }}">
                                            {{ $service['Spec']['TaskTemplate']['ContainerSpec']['Image'] }}
                                        </td>
                                        <td scope="col"
                                            rowspan="{{ isset($service['Spec']['EndpointSpec']['Ports']) ? count($service['Spec']['EndpointSpec']['Ports'])*2 : 2 }}">
                                            {{ $service['Spec']['Mode']['Replicated']['Replicas'] }}
                                        </td>
                                        <td scope="col">
                                            @if(isset($service['Spec']['EndpointSpec']['Ports']))
                                                @foreach($service['Spec']['EndpointSpec']['Ports'] as $port)
                                                    {{ $port['Protocol'] }}<br>
                                                @endforeach
                                            @endif
                                        </td><br>
                                        <td scope="col">
                                            @if(isset($service['Spec']['EndpointSpec']['Ports']))
                                                @foreach($service['Spec']['EndpointSpec']['Ports'] as $port)
                                                    {{ $port['TargetPort'] ?? '' }}<br>
                                                @endforeach    
                                            @endif
                                        </td>
                                        <td scope="col">
                                            @if(isset($service['Spec']['EndpointSpec']['Ports']))
                                                @foreach($service['Spec']['EndpointSpec']['Ports'] as $port)
                                                    <a href="http://0.0.0.0:{{ $port['PublishedPort'] ?? '' }}" target="_blank">{{ $port['PublishedPort'] ?? '' }}</a><br>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td>
                                            <form action="{{ route('services.destroy', $service['ID']) }}" method="post">
                                                @method('delete')
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-primary btn-link" onclick="return confirm('Are you sure? This action not be undone.');">
                                                    <i class="material-icons">delete</i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                </tbody>
                                @endforeach
                            </table>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-11 text-right" style="margin-left: 48px;">
                    <button class="btn btn-primary btn-fab btn-round" title="Create a service.">
                        <a href="{{ route('services.create') }}">
                            <i class="material-icons" style="color:white">add_to_queue</i>
                        </a>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection