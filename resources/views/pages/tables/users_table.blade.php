<table class='table'>
    <thead>
        <th>#</th>
        <th>Name</th>
        <th>Email</th>
        <th>Type</th>
        <th>Machines</th>
        <th>Containers</th>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->user_type }}</td>
            <td>{{ $machinesCount[$user->id]}}</td>
            <td>{{ $containersCount[$user->id] }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
{!! $users->links() !!}