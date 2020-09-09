<table class='table'>
    <thead>
        <th>#</th>
        <th>Hashcode</th>
        <th>User</th>
        <th>CPU/RAM Available</th>
        <th>Time Activity</th>
        <th>Running</th>
        <th>Options</th>
    </thead>
    <tbody>
        @foreach ($machines as $machine)
        <tr>
            <td><span class="material-icons">computer</span></td>
            <td>{{ $machine->hashcode }}</td>
            <td>{{ $machine->user()->name }}</td>
            <td>
                {{ $machine->cpu_utilizavel }}%
                <span>/</span>
                {{ $machine->ram_utilizavel }}MB
            </td>
            <td>{{ $machine->totalTimeActivity(2) }} Hrs</td>
            <td>
                @if($machine->disponivel)
                <div class="spinner-grow text-success" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                @else
                <div class="text-danger">
                    <span class="material-icons">crop_square</span>
                </div>
                @endif
            </td>
            <td class="td-actions text-right">
                <div class='row'>
                    <a rel="tooltip" class="btn btn-success btn-link btn-sm" data-toggle="collapse"
                        data-target="#{{ $machine->id }}" aria-expanded="false" aria-controls="collapseExample">
                        <i class="material-icons">details</i>
                    </a>
                    <button type="button" class="btn btn-warning btn-link btn-sm" data-toggle="modal" data-target="#machineModal{{$machine->id}}">
                        <i class="material-icons">edit</i>
                    </button>
                    @include('pages.user.machines_modal', ['machine' => $machine])
                    {!! Form::open(['route' => ['machines.destroy', $machine], 'method' => 'delete']) !!}
                    <button type="submit" class="btn btn-danger btn-link btn-sm" data-original-title="" title=""
                        onclick="return confirm('Are you sure?')" type="submit">
                        <i class=" material-icons">delete</i>
                    </button>
                    {!! Form::close() !!}
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="7">
                <div class="collapse" id="{{ $machine->id }}">
                    @include('pages.user.machine_show_form', ['machine' => $machine])
                    <a href="{{ route('machines.show', $machine) }}" class="btn btn-sm btn-outline-info">
                        More
                    </a>
                    <button class="btn btn-sm btn-outline" type="button" data-toggle="collapse"
                        data-target="#{{ $machine->id }}" aria-expanded="false" aria-controls="collapseExample">
                        Ocult
                    </button>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{!! $machines->links() !!}
