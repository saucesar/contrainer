@extends('layouts.app', ['activePage' => 'my-containers', 'titlePage' => __("Container name: $mycontainer->nickname")])

@section('content')

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title ">Container Terminal Tab</h4>
                        <p class="card-category">Command to container {{ $mycontainer->nickname }}</p>
                    </div>
                    <div class="card-body">
                        Tecle Enter
                        <div id="terminal"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
var socketParams = <?= $socketParams; ?>;
var host = socketParams['dockerHost'];
var containerId = socketParams['container_id'];
var endpoint = "/attach/ws?logs=0&stream=1&stdin=1&stdout=1&stderr=1";

const url = host+'/containers/'+containerId+endpoint;

console.log('url => ' + url);
const webSocket = new WebSocket(url);

const attachAddon = new AttachAddon.AttachAddon(webSocket);
const fitAddon = new FitAddon.FitAddon();
const webLinksAddon = new WebLinksAddon.WebLinksAddon();
const term = new Terminal();

term.loadAddon(attachAddon);
term.loadAddon(fitAddon);
term.loadAddon(webLinksAddon);

term.open(document.getElementById('terminal'));
fitAddon.fit();
term.reset();
</script>
@endpush
