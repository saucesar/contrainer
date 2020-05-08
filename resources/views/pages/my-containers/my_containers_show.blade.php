{!! Form::open(['route' => ['logout', ''], 'method' => 'post']) !!}
    <input style="background: white;" name = 'command'type="text" class = "form-control"
           placeholder = "$ Command" required = "true" aria-required = "true" >
    <button type="submit" class="btn btn-warning btn-link">run in terminal</button>
{!! Form::close() !!}