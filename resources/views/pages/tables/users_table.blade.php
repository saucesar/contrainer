<table class='table'>
    <thead>
        <th>#</th>
        <th>Name</th>
        <th>Email</th>
        <th>Type</th>
        <th>Machines</th>
        <th>Containers</th>
        <th>Options</th>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->user_type }}</td>
            <td>{{ $user->machines()->count()}}</td>
            <td>{{ $user->containers()->count() }}</td>
            <td class="td-actions">
                <div class="btn-group" role="group" aria-label="Basic example">
                    <button class="btn btn-sm btn-link btn-warning" data-toggle="modal"
                            data-target="#modalUser{{ $user->id }}" title="Edit user">
                            <i class="material-icons">edit</i>
                    </button>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{!! $users->links() !!}