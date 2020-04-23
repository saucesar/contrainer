<div class="row">
    {!! Form::label('Name', null, ['class'=>"col-sm-2 col-form-label"]) !!}
    <div class="col-sm">
        {!! Form::text('name', $container->name ?? null, ['class'=>"form-control", 'placeholder' =>"Container name", 'required'=>"true"]) !!}
    </div>
</div>
<br>
<div class="row">
    {!! Form::label('Description', null, ['class'=>"col-sm-2 col-form-label"]) !!}
    <div class="col-sm">
        {!! Form::textarea('description', $container->description ?? null, ['class'=>"form-control", 'placeholder' =>"Enter a description of the image content", 'required'=>"true", 'rows'=>"5"]) !!}
    </div>
</div>
<br>
<div class="row">
    {!! Form::label('Command pull', null, ['class'=>"col-sm-2 col-form-label"]) !!}
    <div class="col-sm">
        {!! Form::text('command_pull', $container->command_pull ?? null, ['class'=>"form-control", 'placeholder' =>"Command to download image a container", 'required'=>"true"]) !!}
    </div>
</div>
<br>
<div class="row">
    {!! Form::label('Command run', null, ['class'=>"col-sm-2 col-form-label"]) !!}
    <div class="col-sm">
        {!! Form::text('command_run', $container->command_run ?? null, ['class'=>"form-control", 'placeholder' =>"Command to create a container", 'required'=>"true"]) !!}
    </div>
</div>
<br>
<div class="row">
    {!! Form::label('Programs', null, ['class'=>"col-sm-2 col-form-label"]) !!}
    <div class="col-sm">
        {!! Form::text('programs', $container->programs ?? null, ['class'=>"form-control", 'placeholder' =>"programs contained in this image"]) !!}
    </div>
</div>
<br>
<div class="row">
    <div class="col-sm">
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</div>
<br>