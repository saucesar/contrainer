@extends('layouts.app', ['activePage' => 'services', 'titlePage' => __("Services"), 'title' => __("Services")])

@push('js')
@endpush

@section('content')
<div class="content">
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
                            @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif
                            @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @foreach($services as $service)
                            <table class="table table-bordered table-hover text-center">
                                <thead class="thead-light">
                                    <th>Name</th>
                                    <th>Image</th>
                                    <th>Replicas</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td scope="col">{{ $service['Spec']['Name'] }}</td>
                                        <td scope="col">{{ $service['Spec']['TaskTemplate']['ContainerSpec']['Image'] }}</td>
                                        <td scope="col">{{ $service['Spec']['Mode']['Replicated']['Replicas'] }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">Ports</td>
                                    </tr>
                                    <tr>
                                        <td>Protocol</td>
                                        <td>Target</td>
                                        <td>Published</td>
                                    </tr>
                                    @foreach($service['Spec']['EndpointSpec']['Ports'] as $port)
                                    <tr>
                                        <td scope="col">{{ $port['Protocol'] }}</td>
                                        <td scope="col">{{ $port['TargetPort'] }}</td>
                                        <td scope="col">{{ $port['PublishedPort'] }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection