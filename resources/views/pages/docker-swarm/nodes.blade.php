@extends('layouts.app', ['activePage' => 'swarm-nodes', 'titlePage' => __("Swarm Nodes"), 'title' => __("SwarmNodes")])

@push('js')
@endpush

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">Docker Swarm</h4>
                            <p class="card-category">Your Nodes</p>
                        </div>
                        <div class="card-body">
                            @include('pages.components.messages')

                            <h3>Nodes</h3>
                            
                            <table class="table table-bordered">
                                <thead class="">
                                    <th>ID</th>
                                    <th>Role</th>
                                    <th>Plataform</th>
                                    <th>Hostname</th>
                                    <th>Memory</th>
                                    <th>Status</th>
                                    <th>Addr</th>
                                    <th>EngineVersion</th>
                                </thead>
                                <tbody>
                                @foreach($nodes as $node)
                                    <tr>
                                        <td scope="col">{{ $node['ID'] }}</td>
                                        <td scope="col">{{ $node['Spec']['Role'] }}</td>
                                        <td scope="col">{{ $node['Description']['Platform']['OS'].'_'.$node['Description']['Platform']['Architecture'] }}</td>
                                        <td scope="col">{{ $node['Description']['Hostname'] }}</td>
                                        <td scope="col">{{ round($node['Description']['Resources']['MemoryBytes']/pow(1024, 3), 2) }} GB</td>
                                        <td scope="col">{{ $node['Spec']['Availability'] }}/{{ $node['Status']['State'] }}</td>
                                        <td scope="col">{{ $node['Status']['Addr'] }}</td>
                                        <td scope="col">{{ $node['Description']['Engine']['EngineVersion'] }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection