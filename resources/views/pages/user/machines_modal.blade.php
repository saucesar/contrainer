<div class="modal" id="machineModal{{ $machine->id ?? '' }}" tabindex="-1"  role="dialog" aria-labelledby="modalLabel{{ $machine->id ?? '' }}" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel{{ $machine->id ?? ''}}">Edit Machine</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      {!! Form::open(['route' => isset($machine) ? ['machines.update', $machine] : 'machines.store', 'method' => isset($machine) ? 'put' : 'post']) !!}
      <div class="modal-body">
            @include('pages.user.machine_form',['machine' => $machine ?? null])
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
      {!! Form::close() !!}
    </div>
  </div>
</div>