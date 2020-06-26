<table class='table'>
    <thead>
        <th>#</th>
        <th>Name</th>
        <th>Description</th>
        <th>Options</th>
    </thead>
    <tbody>
        @foreach ($containers as $container)
        <tr>
            <td><i class="fab fa-docker card-header-info ml-auto"></i></td>
            <td>{{ $container->name }}</td>
            <td width='550px'>{{ $container->description }}</td>
            <td class="td-actions text-right">
                <div class='row'>
                    {!! Form::open(['route' => 'instance.configure', 'method' => 'post']) !!}
                    <input type="hidden" value="{{ $container->id }}" name='image_id'>
                    <input type="hidden" value="{{ $user_id }}" name='user_id'>
                    <button type="submit" class="btn btn-sucess btn-link">
                        <i class="material-icons">play_circle_filled</i>
                        Run
                    </button>
                    {!! Form::close() !!}
                    @if ($isAdmin)
                    <a rel="tooltip" class="btn btn-success btn-link" data-toggle="collapse"
                        data-target="#{{ $container->id }}" aria-expanded="false" aria-controls="collapseExample">
                        <i class="material-icons">details</i>
                        <div class="ripple-container"></div>
                    </a>
                    <a href="{{ route('containers.edit', $container) }}" class="btn btn-warning btn-link">
                        <i class="material-icons">edit</i>
                    </a>
                    {!! Form::open(['route' => ['containers.destroy', $container], 'method' => 'delete']) !!}
                    <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-danger btn-link">
                        <i class="material-icons">delete_sweep</i>
                    </button>
                    {!! Form::close() !!}
                    @endif
                </div>
            </td>
        </tr>
        <tr>
            <td></td>
            <td colspan="3">
                <div class="collapse" id="{{ $container->id }}">
                    @include('pages.containers.containers_show_form', ['container' => $container, 'isAdmin' =>
                    $isAdmin])
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
