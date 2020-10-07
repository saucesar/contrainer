<script type="text/javascript" src="{{ asset('js') }}/cloud.js"></script>

<div class="modal" id="modalContainersService" tabindex="-1" role="dialog" aria-labelledby="modalContainersLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalContainersLabel">Change default template to create containers</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {!! Form::open(['route' => 'container-template.update', 'method' => 'put']) !!}
            <div class="modal-body">
                @include('pages/settings/container_form')
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