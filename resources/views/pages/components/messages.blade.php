@if(isset($error))
<div class="alert alert-danger">
    {{ $error }}
    <button class="close alert-dismissible btn btn-link" data-dismiss="alert">
        <i class="material-icons">close</i>
    </button>
</div>
@endif
@if(session('success'))
<div class="alert alert-success" role="alert">
    {{ session('success') }}
    <button class="close alert-dismissible btn btn-link" data-dismiss="alert">
        <i class="fas fa-times"></i>
    </button>
</div>
@elseif(session('error'))
<div class="alert alert-danger" role="alert">
    {{ session('error') }}
    <button class="close alert-dismissible btn btn-link" data-dismiss="alert">
        <i class="fas fa-times"></i>
    </button>
</div>
@endif
@if ($errors->any())
<div class="alert alert-danger">
    <div class="row">
        <div class="col-10">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        <div class="col-2">
            <button class="close alert-dismissible btn btn-link" data-dismiss="alert">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
</div>
@endif