@extends('layouts.app', ['activePage' => 'docker-swarm', 'titlePage' => __("Docker Swarm"), 'title' =>
__("DockerSwarm")])

@push('js')
<script src="{{ asset('js') }}/FileSaver.min.js" type="text/javascript"></script>
<script>
function saveFile() {
    let text = "#!/bin/bash\ndocker swarm join --token={{ $swarm['JoinTokens']['Manager'].' '.$manager['Status']['Addr'] }}";
    let title = "join-swarm.sh";
    let blob = new Blob([text], {
        type: "text/plain;charset=utf-8"
    });
    saveAs(blob, title);
}
</script>
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

                            @if($swarm)
                            <h3>Manager Info</h3>
                            <table class="table table-bordered">
                                <thead class="">
                                    <th>ID</th>
                                    <th>Hostname</th>
                                    <th>Plataform</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td scope="col">{{ $swarm['ID'] }}</td>
                                        <td scope="col">{{ $manager['Description']['Hostname']  }}</td>
                                        <td scope="col">
                                            {{ $manager['Description']['Platform']['OS'].'_'.$manager['Description']['Platform']['Architecture'] }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <table class="table table-bordered">
                                <thead class="">
                                    <th>IP</th>
                                    <th>State</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td scope="col">{{ $manager['Status']['Addr'] }}</td>
                                        <td scope="col">{{ $manager['Status']['State'] }}</td>
                                    </tr>
                                </tbody>
                            </table>

                            <table class="table table-bordered">
                                <thead class="">
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th>DataPathPort</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td scope="col">{{ $swarm['CreatedAt'] }}</td>
                                        <td scope="col">{{ $swarm['UpdatedAt'] }}</td>
                                        <td scope="col">{{ $swarm['DataPathPort'] }}</td>
                                    </tr>
                                </tbody>
                            </table>

                            <table class="table table-bordered">
                                <thead class="">
                                    <th>To join in this swarm as manager run</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td scope="col">
                                            <small><b>docker swarm join --token={{ $swarm['JoinTokens']['Manager'].' '.$manager['Status']['Addr'] }}</b></small>
                                            <button class="btn btn-sm btn-link" onclick="saveFile()" title="save a file with bash script to join the swarm">
                                                <i class="material-icons">get_app</i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <form action="{{ route('docker-swarm.leave') }}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-lg" onclick="return confirm('are you sure?q')">
                                    <i class="fas fa-sign-out-alt"> Leave to a Swarm </i>
                                </button>
                            </form>
                            @else
                            <form action="{{ route('docker-swarm.init') }}" method="post">
                                @csrf
                                <input type="text" class="form-control" name="ip" value=""
                                    placeholder="enter the ip or leave it blank to try to get it automatically.">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-plus-circle"> Initialize new Swarm </i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection