@include('pages.components.messages')
<div class="row">
    {!! Form::label('Name', null, ['class'=>"col-sm-2 col-form-label"]) !!}
    <div class="col-sm">
        {!! Form::text('name', $image->name ?? null, ['class'=>"form-control", 'placeholder' =>"Image name", 'required'=>"true"]) !!}
    </div>
</div>
<br>
<div class="row">
    {!! Form::label('Description', null, ['class'=>"col-sm-2 col-form-label"]) !!}
    <div class="col-sm">
        {!! Form::textarea('description', $image->description ?? null,
            [
                'class'=>"form-control",
                'placeholder' =>"Enter a description.",
                'title' =>"Enter a description of the image content",
                'required'=>"true",
                'rows'=>"5"
            ])
        !!}
    </div>
</div>
<br>
<div class="row">
    {!! Form::label('From Image', null, ['class'=>"col-sm-2 col-form-label"]) !!}
    <div class="col-sm">
        {!! Form::text('fromImage', $image->fromImage ?? null,
            [
                'class'=>"form-control",
                'placeholder'=>"Name of the image to pull.",
                'title' => "Name of the image to pull. The name may include a tag or digest. ".
                           "This parameter may only be used when pulling an image. ".
                           "The pull is cancelled if the HTTP connection is closed.",
                'required'=>"true",
                'rows'=>"5"
            ])
        !!}
    </div>
</div>
<br>
<div class="row">
    {!! Form::label('From Source', null, ['class'=>"col-sm-2 col-form-label"]) !!}
    <div class="col-sm">
        {!! Form::text('fromSrc', $image->fromSrc ?? null,
            [
                'class' => "form-control",
                'placeholder' => "Source to import.",
                'title' => "Source to import.".
                           "The value may be a URL from which the image can be retrieved".
                           "or - to read the image from the request body. ".
                           "This parameter may only be used when importing an image.",
            ])
        !!}
    </div>
</div>
<br>
<div class="row">
    {!! Form::label('Repository', null, ['class'=>"col-sm-2 col-form-label"]) !!}
    <div class="col-sm">
        {!! Form::text('repo', $image->repo ?? null,
            [
                'class'=>"form-control",
                'placeholder'=>"Repository name given to an image when it is imported.",
                'title' => "Repository name given to an image when it is imported. ".
                            "The repo may include a tag. ".
                            "This parameter may only be used when importing an image.",
            ])
        !!}
    </div>
</div>
<br>
<div class="row">
    {!! Form::label('Tag', null, ['class'=>"col-sm-2 col-form-label"]) !!}
    <div class="col-sm">
        {!! Form::text('tag', $image->tag ?? null,
            [
                'class'=>"form-control",
                'placeholder' => "Tag or digest. ",
                'title' => "Tag or digest. ".
                           "If empty when pulling an image, ".
                           "this causes all tags for the given image to be pulled.",
                'required'=>'true'
            ])
        !!}
    </div>
</div>
<br>
<div class="row">
    {!! Form::label('Message', null, ['class'=>"col-sm-2 col-form-label"]) !!}
    <div class="col-sm">
        {!! Form::text('message', $image->message ?? null,
            [
                'class'=>"form-control",
                'placeholder' => "Set commit message for imported image.",
                'title' => "Set commit message for imported image.",
            ])
        !!}
    </div>
</div>
<br>
<div class="row">
    <div class="col-sm">
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</div>
<br>
