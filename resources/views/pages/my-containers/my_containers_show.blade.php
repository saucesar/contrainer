{!! Form::open(['route' => ['instance.execInTerminal', $mycontainer->docker_id], 'method' => 'post']) !!}
    <input style="background: white;" name = 'command'type="text" class = "form-control"
           placeholder = "$ Command" required = "true" aria-required = "true" >
    <input type="hidden" value="{{$newTab}}" name="newTab">
    <button type="submit" class="btn btn-warning btn-link">execute</button>
    @if(!$newTab)
        <a href="{{ route('container.terminalTab', $mycontainer->docker_id) }}" class="btn btn-warning btn-link" target="_black">open in new tab</a>
    @endif
    <div style="background: white;">
    <p>
        <table class='table'>
            <thead>
                <th>Command</th>
                <th>Output</th>
                <th>Executed at</th>
                <th>Status</th>
            </thead>
            <tbody>
                @foreach($consoleOuts as $consoleOut)
                    @if($consoleOut->docker_id == $mycontainer->docker_id)
                        <tr>
                            <td>$ {{ $consoleOut->command }}</td>
                            <td width="500px" style="font-size: 12px">{{ $consoleOut->out }}</td>
                            <td>{{ $consoleOut->created_at }}</td>
                            @if($consoleOut->status)
                                <td><a class="btn btn-success btn-link"><i class="material-icons">check_circle</i></a></td>
                            @else
                                <td><a class="btn btn-danger btn-link" ><i class="material-icons">highlight_off</i></a></td>
                            @endif
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </p>
    </div>
{!! Form::close() !!}