<div class="row ml-1 mr-1">
    <div class="col">
        <div class="row">
            <label for="name">Name</label>
            <input class="form-control"  type="text" name="name" value="{{ $category->name ?? old('name') }}" required>
        </div>
        <br>
        <div class="row">
            <label for="ram_limit">RAM Limit (MB)</label>
            <input class="form-control"  type="number" name="ram_limit" value="{{ $category->ram_limit ?? old('ram_limit')  }}" required>
        </div>
        <br>
        <div class="row">
            <label for="storage_limit">Storage Limit (MB)</label>
            <input class="form-control"  type="number" name="storage_limit" value="{{ $category->storage_limit ?? old('storage_limit')  }}" required>
        </div>
    </div>
</div>