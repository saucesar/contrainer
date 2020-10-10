<div class="modal" id="modalUserCategory{{ $category->id ?? $id }}" tabindex="-1" role="dialog" aria-labelledby="modalUserCatLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalUserCatLabel">User Categories</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ $route }}" method="{{ 'POST' }}">
                @csrf
                @method($method)
                <div class="modal-body">
                    @include('pages/settings/user_categories_form')
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" class="btn btn-success">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>