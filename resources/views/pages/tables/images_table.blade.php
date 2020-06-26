<table class='table'>
    <thead>
        <th>#</th>
        <th>Name</th>
        <th>Description</th>
        <th>Options</th>
    </thead>
    <tbody>
        @foreach ($images as $image)
        <tr>
            <td><i class="fab fa-docker card-header-info ml-auto"></i></td>
            <td>{{ $image->name }}</td>
            <td width='550px'>{{ $image->description }}</td>
            <td class="td-actions text-right">
                <div class='row'>
                    {!! Form::open(['route' => 'instance.configure', 'method' => 'post']) !!}
                    <input type="hidden" value="{{ $image->id }}" name='image_id'>
                    <input type="hidden" value="{{ $user_id }}" name='user_id'>
                    <button type="submit" class="btn btn-sucess btn-link">
                        <i class="material-icons">play_circle_filled</i>
                        Run
                    </button>
                    {!! Form::close() !!}
                    @if ($isAdmin)
                    <a rel="tooltip" class="btn btn-success btn-link" data-toggle="collapse"
                        data-target="#{{ $image->id }}" aria-expanded="false" aria-controls="collapseExample">
                        <i class="material-icons">details</i>
                        <div class="ripple-container"></div>
                    </a>
                    <a href="{{ route('images.edit', $image) }}" class="btn btn-warning btn-link">
                        <i class="material-icons">edit</i>
                    </a>
                    {!! Form::open(['route' => ['images.destroy', $image], 'method' => 'delete']) !!}
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
                <div class="collapse" id="{{ $image->id }}">
                    @include('pages.images.images_show_form', ['image' => $image, 'isAdmin' => $isAdmin])
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
