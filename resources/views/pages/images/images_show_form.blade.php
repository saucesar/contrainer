<p><label> Tag :</label> {{ $image->tag }}</p>
@if ($isAdmin)
    <p><label> Created at  :</label> {{ $image->created_at }}</p>
    <p><label> Updated at  :</label> {{ $image->updated_at }}</p>
@endif
