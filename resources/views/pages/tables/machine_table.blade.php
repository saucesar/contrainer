<table class='table'>
    <thead>
        <th>#</th>
        <th>Hashcode</th>
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
                <div class='row' style=" margin-top: 12px;">
                    <a rel="tooltip" class="btn btn-success btn-link" data-toggle="collapse"
                        data-target="#{{ $machine->id }}" aria-expanded="false" aria-controls="collapseExample">
                        <i class="material-icons">details</i>
                        <div class="ripple-container"></div>
                    </a>
                    <a rel="tooltip" class="btn btn-warning btn-link" href="{{ route('machines.edit', $machine) }}"
                        data-original-title="" title="">
                        <i class="material-icons">edit</i>
                        <div class="ripple-container"></div>
                    </a>
                    {!! Form::open(['route' => ['machines.destroy', $machine], 'method' => 'delete']) !!}
                    <button type="button" class="btn btn-danger btn-link" data-original-title="" title=""
                        onclick="return confirm('Are you sure?')" type="submit">
                        <i class=" material-icons">delete</i>
                        <div class="ripple-container"></div>
                    </button>
                    {!! Form::close() !!}
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="6">
                <div class="collapse" id="{{ $machine->id }}">
                    @include('pages.user.machine_show_form', ['machine' => $machine])
                    <a href="{{ route('machines.show', $machine) }}" class="btn btn-sm btn-outline-info">
                        More Details
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
