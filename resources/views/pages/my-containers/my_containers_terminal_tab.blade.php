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
var url = "ws://localhost:12345/containers/fd0e74a9d1499e9c58ee0e67/attach/ws?logs=1&stream=1&stdin=1&stdout=1&stderr=1";
var webSocket = new WebSocket(url);

var attachAddon = new AttachAddon.AttachAddon(webSocket);
var fitAddon = new FitAddon.FitAddon();

var term = new Terminal();

const prompt = '\r\n\x1B[1;3;32mdocker@docker\x1B[0m $ ';
var buffer = [];

term.loadAddon(attachAddon);
term.loadAddon(fitAddon);
term.open(document.getElementById('terminal'));
term.write(prompt);
fitAddon.fit();

term.prompt = () => {
    term.write(prompt);
};

webSocket.onopen = function(evt){
    alert('Connection open!');
}

webSocket.onmessage = function(evt){
    term.write(evt.data);
    term.prompt();
}
webSocket.onclose = function(evt){
    term.write("\r\nClose connection!");
    term.prompt();
}

term.onKey(key => {
    const ev = key.domEvent;
    const printable = !ev.altKey && !ev.ctrlKey && !ev.metaKey;
    if (ev.keyCode === 13) {
        console.log('enter');

        if(buffer == 'clear'){
            term.clear();
        } else {
            term.write('\r\n');
            webSocket.send(buffer);
            console.log('Socket State: ' + webSocket.readyState);
        }
        term.prompt();
        buffer = [];
    } else if (ev.keyCode === 8) {
        console.log('backspace');

        buffer = buffer.slice(0, -1);
        if (term._core.buffer.x > 2) {
            term.write('\b \b');
        }
    } else if (printable) {
        term.write(key.key);
        buffer += key.key;
    }
});
</script>
@endpush
