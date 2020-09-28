@extends('layouts.app', ['activePage' => 'settings', 'titlePage' => __("Settings"), 'title' => __("Settings")])

@push('js')
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
                                <h2>Service Template</h2>
                            </div>
                            <div class="row d-flex justify-content-center">
                                <h3>TaskTemplate
                                    <button class="btn btn-warning btn-link" data-toggle="modal" data-target="#modalServices" title="Edit services template">
                                        <i class="material-icons">edit</i>
                                    </button>
                                </h3>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <h4>ContainerSpec</h4>
                                    <h5>DNSConfig</h5>
                                    <p>Nameservers: {{ implode(', ', $service_template['TaskTemplate']['ContainerSpec']['DNSConfig']['Nameservers']) }}</p>
                                    <p>Search: {{ implode(', ', $service_template['TaskTemplate']['ContainerSpec']['DNSConfig']['Search']) }}</p>
                                    <p>Options: {{ implode(', ', $service_template['TaskTemplate']['ContainerSpec']['DNSConfig']['Options']) }}</p>
                                    <p>TTY: {{ $service_template['TaskTemplate']['ContainerSpec']['TTY'] ? 'True' : 'False' }}</p>
                                    <p>OpenStdin: {{ $service_template['TaskTemplate']['ContainerSpec']['OpenStdin'] ? 'True' : 'False' }}</p>
                                </div>
                                <div class="col">
                                    <h4>Resources</h4>
                                    <p>Memory Limite: {{ $service_template['TaskTemplate']['Resources']['Limits']['MemoryBytes']/(1024*1024) }} MB</p>
                                </div>
                                <div class="col">
                                    <h4>RestartPolicy</h4>
                                    <p>Condition: {{ $service_template['TaskTemplate']['RestartPolicy']['Condition'] }}</p>
                                    <p>Delay: {{ $service_template['TaskTemplate']['RestartPolicy']['Delay'] }}</p>
                                    <p>MaxAttempts: {{ $service_template['TaskTemplate']['RestartPolicy']['MaxAttempts'] }}</p>
                                </div>
                                <div class="col">
                                    <h4>ForceUpdate</h4>
                                    <p>Condition: {{ $service_template['TaskTemplate']['ForceUpdate'] }}</p>
                                </div>
                                <div class="col">
                                    <h4>Runtime</h4>
                                    <p>Condition: {{ $service_template['TaskTemplate']['Runtime'] }}</p>
                                </div>
                            </div>
                            <div class="row d-flex justify-content-center">
                                <div class="col-3">
                                    <h3>Mode</h3>
                                    <p>Replicated/Replicas: {{ $service_template['Mode']['Replicated']['Replicas'] }}</p>
                                </div>
                                <div class="col-9">
                                    <h3>UpdateConfig</h3>
                                </div>
                            </div>
                            <div class="row d-flex justify-content-center"> 
                                <div class="col-3">

                                </div>                       
                                <div class="col-9">
                                    <p>Paralelism: {{ $service_template['UpdateConfig']['Parallelism'] }}</p>
                                    <p>FailureAction: {{ $service_template['UpdateConfig']['FailureAction'] }}</p>
                                    <p>Monitor: {{ $service_template['UpdateConfig']['Monitor'] }}</p>
                                    <p>MaxFailureRatio: {{ $service_template['UpdateConfig']['MaxFailureRatio'] }}</p>
                                    <p>Order: {{ $service_template['UpdateConfig']['Order'] }}</p>
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