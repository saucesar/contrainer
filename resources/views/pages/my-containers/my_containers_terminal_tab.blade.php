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
const url = "ws://localhost:12345/v1.27/containers/37fa431533f1/attach/ws?logs=1&stream=1&stdin=1&stdout=1&stderr=1";
//const url = "ws://echo.websocket.org";
const webSocket = new WebSocket(url);

const attachAddon = new AttachAddon.AttachAddon(webSocket);
const fitAddon = new FitAddon.FitAddon();
const term = new Terminal();

term.loadAddon(attachAddon);
term.loadAddon(fitAddon);

term.open(document.getElementById('terminal'));
fitAddon.fit();
term.reset();
</script>
@endpush
