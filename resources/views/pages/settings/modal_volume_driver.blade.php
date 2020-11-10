<div class="modal" id="modalVolumeDriver" tabindex="-1" role="dialog" aria-labelledby="modalVolumeDriverLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalVolumeDriverLabel">Change default volume driver for containers.</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {!! Form::open(['route' => 'volume-driver.update', 'method' => 'put']) !!}
            <div class="modal-body row">
                <div class="col-10">
                    <label for="driver_name">Volume Driver</label>
                    <input type="text" name="driver_name" class='form-control' value="{{ $volume_driver['Driver'] }}">
                </div>
                <div class="col-10">
                    <br>
                    <h4>Driver Options</h4>
                </div>
                <div class="col-10" id="colDriverOpts">
                    <div class="row">
                        <div class="col-5">
                            <input type="text" name="OptKeys[]" class="form-control">
                        </div>
                        <div class="col-5">
                            <input type="text" name="OptValues[]" class="form-control">
                        </div>
                        <div class="col-2" id="colBtnRemoveOpt1">
                        </div>
                    </div>
                    @foreach(array_keys($volume_driver['DriverOpts']) as $optKey)
                    <div class="row">
                        <div class="col-5">
                            <input type="text" name="OptKeys[]" class="form-control" value="{{ $optKey }}">
                        </div>
                        <div class="col-5">
                            <input type="text" name="OptValues[]" class="form-control" value="{{ $volume_driver['DriverOpts'][$optKey] }}">
                        </div>
                        <div class="col-2">
                            <button type="button" class="btn btn-sm btn-link btn-danger" onclick='deleteElement(this, 2);'>X</button>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="col-2">
                    <button class="btn btn-sm btn-success" id="buttonAddDriverOpt" onclick="addDriverOpt();" type="button">Add</button>
                </div>
                <script type="text/javascript">
                var countEnv = 1;

                function addDriverOpt() {
                    var field = '<div class="row"><div class="col-5"><input type="text" name="OptKeys[]" class="form-control">';
                    field += '</div><div class="col-5"><input type="text" name="OptValues[]" class="form-control"></div>';
                    field += '<div class="col-2" id="colBtnRemoveEnv' + (++countEnv) + '"></div></div>';
                    addAtFirst("#colDriverOpts", field);
                    addAtFirst("#colBtnRemoveOpt" + (countEnv - 1),
                        '<button type="button" class="btn btn-sm btn-link btn-danger" onclick="deleteElement(this, 2);">X</button>'
                        );
                }

                function checkDriverOpt() {
                    var button = document.getElementById('buttonAddDriverOpt');
                    button.disabled = !(checkInputArray("OptKeys[]") && checkInputArray("OptValues[]"));
                }

                setInterval(checkDriverOpt, 100);
                </script>
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