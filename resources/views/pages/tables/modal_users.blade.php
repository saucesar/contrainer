<div class="modal" id="modalUser{{ $user->id ?? '' }}" tabindex="-1" role="dialog" aria-labelledby="modalUser"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalUser">Edit user ( {{ $user->name }} )</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {!! Form::open(['route' => ['user.update', $user->id], 'method' => 'put']) !!}
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" value="{{ $user->name ?? old('name') }}">
                    </div>
                    <div class="col">
                        <label for="name">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ $user->email ?? old('email') }}">
                    </div>
                    <div class="col">
                        <label for="name">Phone</label>
                        <input type="text" name="phone" class="form-control" value="{{ $user->phone ?? old('phone') }}">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col">
                        <label for="name">Type</label>
                        <select name="type" class="form-control">
                            <option value="normal" {{ isset($user) && $user->user_type == 'normal' ? 'selected' : '' }}>Normal</option>
                            <option value="admin" {{ isset($user) && $user->user_type == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>
                    <div class="col">
                        <label for="category_id">Category</label>
                        <select name="category_id" class="form-control">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ isset($user) && $user->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}{{' ( RAM: '.$category->ram_limit.' MB, Storage: '.$category->storage_limit.' MB )'}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">
                    Close
                </button>
                <button type="submit" class="btn btn-success">
                    Save
                </button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>