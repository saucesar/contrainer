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
                            
                            <table class="table table-bordered table-responsive table-hover text-center">
                                <thead class="thead-dark">
                                    <th>ID</th>
                                    <th>Role</th>
                                    <th>Plataform</th>
                                    <th>Hostname</th>
                                    <th>Memory</th>
                                    <th>Status</th>
                                    <th>Addr</th>
                                    <th>Actions</th>
                                </thead>
                                <tbody>
                                @foreach($nodes as $node)
                                    <tr>
                                        <td scope="col">{{ $node['ID'] }}</td>
                                        <td scope="col">{{ $node['Spec']['Role'] }}</td>
                                        <td scope="col">{{ $node['Description']['Platform']['OS'].'_'.$node['Description']['Platform']['Architecture'] }}</td>
                                        <td scope="col">{{ $node['Description']['Hostname'] }}</td>
                                        <td scope="col">{{ round($node['Description']['Resources']['MemoryBytes']/pow(1024, 3), 2) }} GB</td>
                                        <td scope="col">
                                            @if($node['Status']['State'] == 'ready')
                                            <div class="spinner-grow text-success" role="status" title="ready">
                                                <span class="sr-only">Loading...</span>
                                            </div>
                                            @else
                                            <div class="text-danger" role="status" title="stop">
                                                <i class="material-icons">stop</i>
                                            </div>
                                            @endif
                                        </td>
                                        <td scope="col">{{ $node['Status']['Addr'] }}</td>
                                        <td scope="col">
                                            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                                <a class="btn btn-link btn-info" data-toggle="collapse" href="#collapse{{ $node['ID'] }}"
                                                    role="button" aria-expanded="false" aria-controls="collapse{{ $node['ID'] }}" title="Expand details.">
                                                    <span class="material-icons">visibility</span>
                                                </a>
                                                <button class="btn btn-link btn-warning" data-toggle="modal" data-toggle="modal" data-target="#modal{{ $node['ID'] }}">
                                                    <span class="material-icons">create</span>
                                                </button>
                                                <form action="{{ route('nodes.destroy', $node['ID']) }}" method="POST">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-link btn-danger" title="Remove node."
                                                            onclick="return confirm('Are you sure?')">
                                                        <span class="material-icons">delete</span>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" class="text-right">
                                            <div class="collapse" id="collapse{{ $node['ID'] }}">
                                                <small>EngineVersion: {{ $node['Description']['Engine']['EngineVersion'] }}</small>
                                                <table class="table text-left">
                                                    <thead>
                                                        <tr class="text-center">
                                                            <th colspan="7"><h3>Containers</h3></th>
                                                        </tr>
                                                        <tr>
                                                            <th>Service</th>
                                                            <th>Slot</th>
                                                            <th>ContainerID</th>
                                                            <th>PID</th>
                                                            <th>Image</th>
                                                            <th>Memory</th>
                                                            <th>State</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($tasks as $task)
                                                        @if(isset($task['NodeID']) && $task['NodeID'] == $node['ID'])
                                                        <tr>
                                                            <td>{{ $services[$task['ServiceID']]['Spec']['Name'] }}</td>
                                                            <td>{{ $task['Slot'] }}</td>
                                                            <td>{{ isset($task['Status']['ContainerStatus']['ContainerID']) ? substr($task['Status']['ContainerStatus']['ContainerID'], 0, 12) : '' }}</td>
                                                            <td>{{ $task['Status']['ContainerStatus']['PID'] }}</td>
                                                            <td>{{ $task['Spec']['ContainerSpec']['Image'] }}</td>
                                                            <td>{{ $task['Spec']['Resources']['Limits']['MemoryBytes']/pow(1024, 2) }} MB</td>
                                                            <td>
                                                                @if($task['DesiredState'] == 'running')
                                                                <div class="spinner-grow text-success" role="status" title="running">
                                                                    <span class="sr-only">Loading...</span>
                                                                </div>
                                                                @elseif($task['DesiredState'] == 'accepted')
                                                                <div class="spinner-grow text-warning" role="status" title="accepted">
                                                                    <span class="sr-only">Loading...</span>
                                                                </div>
                                                                @else
                                                                <div class="text-danger" role="status" title="stop">
                                                                    <i class="material-icons">stop</i>
                                                                </div>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        @endif
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Modal -->
                                    <div class="modal" id="modal{{ $node['ID'] }}" data-backdrop="static" tabindex="-1" role="dialog"
                                        aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="staticBackdropLabel">Update {{ $node['Description']['Hostname'] }}</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('nodes.update', [$node['ID'], $node['Version']['Index']]) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <label for="Name">Name</label>
                                                        <input type="text" name="Name" class="form-control"
                                                                value="{{ $node['Description']['Hostname'] }}">
                                                        <br>
                                                        <label for="Role">Role</label>
                                                        <select name="Role" class="form-control">
                                                            <option value="worker" {{ $node['Spec']['Role'] == 'worker' ? 'selected' : '' }}>Worker</option>
                                                            <option value="manager" {{ $node['Spec']['Role'] == 'manager' ? 'selected' : '' }}>Manager</option>
                                                        </select>
                                                        <br>
                                                        <label for="Availability">Availability</label>
                                                        <select name="Availability" class="form-control">
                                                            <option value="active" {{ $node['Spec']['Availability'] == 'active' ? 'selected' : '' }}>Active</option>
                                                            <option value="pause" {{ $node['Spec']['Availability'] == 'pause' ? 'selected' : '' }}>Pause</option>
                                                            <option value="drain" {{ $node['Spec']['Availability'] == 'drain' ? 'selected' : '' }}>Drain</option>
                                                        </select>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Save</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
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