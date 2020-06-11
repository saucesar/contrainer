@extends('layouts.app', ['activePage' => 'my-containers', 'titlePage' => __("Container name: $mycontainer->nickname")])

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title ">Container Terminal Tab to {{ $mycontainer->nickname }}</h4>
                        <p class="card-category">Command to container {{ $mycontainer->nickname }}</p>
                    </div>
                    <div class="card-body" style="background: gray;">
                        <div class="table-responsive">
                            @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif
                            @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                            @endif
                            <div id="{{ $mycontainer->id }}">
                                @include('pages.my-containers.my_containers_show', ['mycontainer' => $mycontainer,
                                'consoleOuts' => $consoleOuts, 'newTab' => $newTab])
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h4 class="card-title ">Processes running in {{ $mycontainer->nickname }}</h4>
                    </div>
                    <div class="card-body">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
