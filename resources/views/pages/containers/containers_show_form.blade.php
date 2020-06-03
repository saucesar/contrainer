<p><label> Programs List :</label> {{ $container->programs }}</p>
@if ($isAdmin)
    <p><label> Command pull:</label> {{ $container->command_pull }}</p>
    <p><label> Created at  :</label> {{ $container->created_at }}</p>
    <p><label> Updated at  :</label> {{ $container->updated_at }}</p>
@endif
