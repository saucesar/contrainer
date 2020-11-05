@extends('layouts.app', ['activePage' => 'my-containers', 'title' => 'Container Details', 'titlePage' => __("Container name: $mycontainer->nickname")])

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title ">Container Details</h4>
                        <p class="card-category"> {{ $mycontainer->nickname }}</p>
                    </div>
                    <div class="card-body">
                        <h4 class="card-title ">Processes running in {{ $mycontainer->nickname }}</h4>
                    </div>
                    <div class="card-body">
                        @if($processes)
                        <table class='table'>
                            <thead>
                                @foreach($processes['Titles'] as $title)
                                <th>{{$title}}</th>
                                @endforeach
                            </thead>
                            <tbody>
                                @foreach($processes['Processes'] as $process)
                                <tr>
                                    @foreach($process as $componente)
                                    <td>{{$componente}}</td>
                                    @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <div class="alert alert-danger">Container not Running</div>
                        @endif
                    </div>
                    <div class="card-body">
                        <h4 class="card-title ">Details of {{ $mycontainer->nickname }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            @if($details)
                            <p>
                                <a rel="tooltip" class="btn btn-info" data-toggle="collapse"
                                    data-target="#state" aria-expanded="false" style="width: 220px;">
                                    State
                                    <i class="material-icons">swap_vert</i>
                                </a>
                                <a rel="tooltip" class="btn btn-info" data-toggle="collapse"
                                    data-target="#hostconfig" aria-expanded="false" style="width: 220px;">
                                    Host Config
                                    <i class="material-icons">swap_vert</i>
                                </a>
                                <a rel="tooltip" class="btn btn-info" data-toggle="collapse"
                                    data-target="#config" aria-expanded="false" style="width: 220px;">
                                    Config
                                    <i class="material-icons">swap_vert</i>
                                </a>
                                <a rel="tooltip" class="btn btn-info" data-toggle="collapse"
                                    data-target="#network" aria-expanded="false" style="width: 220px;">
                                    Network Settings
                                    <i class="material-icons">swap_vert</i>
                                </a>
                            </p>
                            <p>
                                <div class="collapse" id="state">
                                    <p><b>Status: </b>{{ $details['State']['Status'] }}</p>
                                    <p><b>Error: </b>{{ $details['State']['Error'] }}</p>
                                    <p><b>Started At: </b>{{ $details['State']['StartedAt'] }}</p>
                                    <p><b>Finished At: </b>{{ $details['State']['FinishedAt'] }}</p>
                                </div>

                                <div class="collapse" id="hostconfig">
                                    <p><b> RestartPolicy: </b>{{$details['HostConfig']['RestartPolicy']['Name']}}</p>
                                    <p>
                                        <b>Binds: </b>
                                        <br>
                                        @if(isset($details['HostConfig']['Binds']))
                                            @foreach($details['HostConfig']['Binds'] as $bind)
                                                {{$bind}} <br>
                                            @endforeach
                                        @endif
                                    </p>
                                    <p><b> NetworkMode: </b>{{$details['HostConfig']['NetworkMode']}}</p>
                                    <p><b> VolumeDriver: </b>{{$details['HostConfig']['VolumeDriver']}}</p>
                                    <p>
                                        <b> Dns: </b>
                                        @if($details['HostConfig']['Dns'])
                                            @foreach($details['HostConfig']['Dns'] as $dns)
                                                {{$dns}} <br>
                                            @endforeach
                                        @endif
                                    </p>
                                    <p>
                                        <b> DnsOptions: </b>
                                        @if($details['HostConfig']['DnsOptions'])

                                            @foreach($details['HostConfig']['DnsOptions'] as $dns)
                                                {{$dns}} <br>
                                            @endforeach
                                        @endif
                                    </p>
                                    <p>
                                        <b> DnsSearch: </b>
                                        @if($details['HostConfig']['DnsSearch'])
                                            @foreach($details['HostConfig']['DnsSearch'] as $dns)
                                                {{$dns}} <br>
                                            @endforeach
                                        @endif
                                    </p>
                                    <p><b> ExtraHosts: </b>{{$details['HostConfig']['ExtraHosts']}}</p>
                                    <p><b> Privileged: </b>{{$details['HostConfig']['Privileged'] ? 'True' : 'False'}}</p>
                                    <p><b> PublishAllPorts: </b>{{$details['HostConfig']['PublishAllPorts'] ? 'True' : 'False'}}</p>
                                    <p><b> UTSMode: </b>{{$details['HostConfig']['UTSMode']}}</p>
                                </div>

                                <div class="collapse" id="config">
                                    <p><b>Hostname: </b>{{ $details['Config']['Hostname'] }}</p>
                                    <p><b>Domainname: </b>{{ $details['Config']['Domainname'] }}</p>
                                    <p><b>AttachStdin: </b>{{ $details['Config']['AttachStdin'] ? 'True' : 'False' }}</p>
                                    <p><b>AttachStdout: </b>{{ $details['Config']['AttachStdout'] ? 'True' : 'False' }}</p>
                                    <p><b>AttachStderr: </b>{{ $details['Config']['AttachStderr'] ? 'True' : 'False' }}</p>
                                    <p><b>Tty: </b>{{ $details['Config']['Tty'] ? 'True' : 'False' }}</p>
                                    <p><b>OpenStdin: </b>{{ $details['Config']['OpenStdin'] ? 'True' : 'False' }}</p>
                                    <p><b>StdinOnce: </b>{{ $details['Config']['StdinOnce'] ? 'True' : 'False' }}</p>
                                    <p>
                                        <b>Env: </b>
                                        <br>
                                        @foreach($details['Config']['Env'] as $env)
                                            {{$env}} <br>
                                        @endforeach
                                    </p>
                                    <p>
                                        <b>Cmd: </b>
                                        <br>
                                        @if($details['Config']['Cmd'])
                                            @foreach($details['Config']['Cmd'] as $cmd)
                                                {{$cmd}} <br>
                                            @endforeach
                                        @endif
                                    </p>
                                    <p><b>Image: </b>{{ $details['Config']['Image'] }}</p>
                                    <p><b>WorkingDir: </b>{{ $details['Config']['WorkingDir'] }}</p>
                                    <p>
                                        <b>Entrypoint: </b>
                                        <br>
                                        @foreach($details['Config']['Entrypoint'] as $entry)
                                            {{$entry}} <br>
                                        @endforeach
                                    </p>
                                    <p>
                                        <b>Labels: </b>
                                        <br>
                                        @foreach($details['Config']['Labels'] as $label)
                                            {{ array_search($label, $details['Config']['Labels']) }}
                                            {{ " : $label"}}
                                        @endforeach
                                    </p>
                                    <p><b>StopSignal: </b>{{ $details['Config']['StopSignal'] }}</p>

                                </div>

                                <div class="collapse" id="network">
                                    <p><b>Bridge: </b>{{ $details['NetworkSettings']['Bridge'] }}</p>
                                    <p><b>SandboxID: </b>{{ $details['NetworkSettings']['SandboxID'] }}</p>
                                    <p><b>HairpinMode: </b>{{ $details['NetworkSettings']['HairpinMode'] ? 'True' : 'False' }}</p>
                                    <p><b>LinkLocalIPv6Address: </b>{{ $details['NetworkSettings']['LinkLocalIPv6Address'] }}</p>
                                    <p><b>LinkLocalIPv6PrefixLen: </b>{{ $details['NetworkSettings']['LinkLocalIPv6PrefixLen'] }}</p>
                                    <p>
                                        <b>Ports: </b>
                                        <br>
                                        @foreach($details['NetworkSettings']['Ports'] as $ports)
                                            {{ $key = array_search($ports, $details['NetworkSettings']['Ports']) }} =>
                                            @if(isset($ports))
                                                @foreach($ports as $portNumber)
                                                    {{ $portNumber['HostIp']}}:{{ $portNumber['HostPort']}}
                                                @endforeach
                                            @endif
                                        @endforeach
                                    </p>
                                    <p><b>SandboxKey: </b>{{ $details['NetworkSettings']['SandboxKey'] }}</p>
                                    <p><b>SecondaryIPAddresses: </b>{{ $details['NetworkSettings']['SecondaryIPAddresses'] }}</p>
                                    <p><b>SecondaryIPv6Addresses: </b>{{ $details['NetworkSettings']['SecondaryIPv6Addresses'] }}</p>
                                    <p><b>EndpointID: </b>{{ $details['NetworkSettings']['EndpointID'] }}</p>
                                    <p><b>Gateway: </b>{{ $details['NetworkSettings']['Gateway'] }}</p>
                                    <p><b>GlobalIPv6Address: </b>{{ $details['NetworkSettings']['GlobalIPv6Address'] }}</p>
                                    <p><b>GlobalIPv6PrefixLen: </b>{{ $details['NetworkSettings']['GlobalIPv6PrefixLen'] }}</p>
                                    <p><b>IPAddress: </b>{{ $details['NetworkSettings']['IPAddress'] }}</p>
                                    <p><b>IPPrefixLen: </b>{{ $details['NetworkSettings']['IPPrefixLen'] }}</p>
                                    <p><b>IPv6Gateway: </b>{{ $details['NetworkSettings']['IPv6Gateway'] }}</p>
                                    <p><b>MacAddress: </b>{{ $details['NetworkSettings']['MacAddress'] }}</p>
                                </div>
                            </p>
                            @else
                            <div class="alert alert-danger">Error to get details</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
