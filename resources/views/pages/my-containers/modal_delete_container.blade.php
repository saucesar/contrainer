<div class="modal" id="modalDeleteContainer{{ $container->docker_id }}" tabindex="-1" role="dialog"
    aria-labelledby="modalDeleteContainerLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDeleteContainerLabel">Delete the Container <strong>{{ $container->nickname }} </strong>?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form action="{{ route('container.delete', $container->docker_id) }}" method="post">
                <div class="modal-body text-left">
                    @csrf
                    <input type="checkbox" name="delete_volume">
                    <label title="Check this option to delete the data saved on the volume. If you do not check the data will still be saved."
                            for="delete_volume">Delete Volume? All data will be lost.</label>
                    <br>
                    <input type="checkbox" name="delete_container" id="confime_delete" required>
                    <label for="delete_container">I understand and want to continue.</label>
                    <h5 class='text-danger'>This action not be undone.</h5>
                </div>
                <div class="modal-footer">
                    <div class=row>
                        <div class='col'>
                            <button type="button" class="btn btn-lg btn-danger" data-dismiss="modal">Close</button>
                        </div>
                        <div class='col'>
                            <button type="submit" class="btn btn-lg btn-success" name="button_delete">Delete</button>
                        </div>
                    </div>
                </div>
            </form>
            <script>
                function checkDelete(){
                    var inputs = document.getElementsByName('delete_container');
                    var buttons = document.getElementsByName('button_delete');
                    
                    for( i = 0; i < inputs.length; i++){
                        buttons[i].disabled = !inputs[i].checked;
                    }
                }
                setInterval(checkDelete, 100);
            </script>
        </div>
    </div>
</div>