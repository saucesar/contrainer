{!! Form::open(['route' => ['instance.execInTerminal', $mycontainer->container_docker_id], 'method' => 'post']) !!}
    <input style="background: white;" name = 'command'type="text" class = "form-control"
           placeholder = "$ Command" required = "true" aria-required = "true" >
    <button type="submit" class="btn btn-warning btn-link">execute</button>
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
                    @if($consoleOut->containerDockerId == $mycontainer->container_docker_id)
                        <tr>
                            <td>$ {{ $consoleOut->command }}</td>
                            <td width="500px">{{ $consoleOut->out }}</td>
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
{!! Form::close() !!}