<div class="modal" id="modalContainers" tabindex="-1" role="dialog" aria-labelledby="modalContainersLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalContainersLabel">Create a Container</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {!! Form::open(['route' => 'containers.store', 'method' => 'post']) !!}
            <div class="modal-body">
                <div class="text-left">
                    <div class="row">
                        <div class="col-sm-10">
                            <select name="image_id" class='form-control' required>
                                <option value="">Select a Image</option>
                                @foreach($images as $image)
                                <option value="{{ $image->id }}">{{ $image->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-10">
                            {!! Form::text('nickname', old('nickname'), ['class'=>"form-control", 'placeholder' => "Nickname to container", 'required'=>"true"]) !!}
                        </div>
                    </div>
                    <h3>Environment Settings</h3>
                    <div class="row">
                        <div class="col-sm-10">
                            <textarea name="envVariables"cols="30" rows="4" class='form-control'
                                      placeholder="Environment variables (Optional) - Use ';' (semicolon) to separate, Ex:PASSWORD=password;POSTGRES_USER=user;">{{ old('envVariables') }}</textarea>
                        </div>
                        <div class="col-sm-10">
                            <textarea name="Labels"cols="30" rows="4" class='form-control'
                            placeholder="Labels (Optional) - Use ';' (semicolon) to separate, Ex: PASSWORD=password;POSTGRES_USER=user;">{{ old('Labels') }}</textarea>
                        </div>
                    </div>
                    <h3>Network Settings</h3>
                    <div class="row">
                        <div class="col-sm-1">
                            <i class="material-icons">device_hub</i>
                        </div>
                        <div class="col-sm-9">
                            {!! Form::text('Hostname', "", ['class'=>"form-control", 'placeholder' =>"(Optional) Add a Hostname"]) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-1">
                            <i class="material-icons">dns</i>
                        </div>
                        <div class="col-sm-9">
                            {!! Form::text('Dns', "", ['class'=>"form-control", 'placeholder' =>"(Optional) Set custom DNS server"]) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-1">
                            <i class="material-icons">dns</i>
                        </div>
                        <div class="col-sm-9">
                            {!! Form::text('DnsOptions', "", ['class'=>"form-control", 'placeholder' =>"(Optional) Set custom DnsOptions"]) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-1">
                            <i class="material-icons">dns</i>
                        </div>
                        <div class="col-sm-9">
                            {!! Form::text('DnsSearch', "", ['class'=>"form-control", 'placeholder' =>"(Optional) Set custom DnsSearch"]) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-1">
                            <i class="material-icons">router</i>
                        </div>
                        <div class="col-sm-9">
                            {!! Form::text('IPAddress', null, ['class'=>"form-control", 'placeholder' =>"(Optional) Add a IPv4"]) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-1">
                            <i class="material-icons">router</i>
                        </div>
                        <div class="col-sm-9">
                            {!! Form::text('IPPrefixLen', null, ['class'=>"form-control", 'placeholder' =>"(Optional) Mask length of the IPv4."]) !!}
                        </div>
                    </div>

                    <br>
                    <div class="row">
                        <div class='col-sm-1'>
                            <i class="material-icons">public</i>
                        </div>
                        <div class=col-sm-6>
                            <label for="#external-port">Add external communication port</label>
                        </div>
                        <div class="col-sm-3">
                            {{ Form::checkbox('external-port', '-P', true, ['id' => 'external-port']) }}
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-1">
                            <i class="material-icons">computer</i>
                        </div>
                        <div class="col-sm-9">
                            {!! Form::text('MacAddress', "", ['class'=>"form-control", 'placeholder' => "(Optional) Add a MacAddress"]) !!}
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-1">
                            <i class="material-icons">memory</i>
                        </div>
                        <div class="col-sm-5">
                            <label for="#Memory">Add a Memory limite.</label>
                        </div>
                        <div class="col-sm-4">
                            <select name="Memory" class='form-control'>
                                <option value="0">default(Unlimited)</option>
                                @for($i = 20; $i <= 200 ; $i += 20)
                                    <option value="{{ $i }}">{{ $i }} MB</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-1">
                            <i class="material-icons">router</i>
                        </div>
                        <div class="col-sm-4">
                            <label for="#NetworkMode">Network mode.</label>
                        </div>
                        <div class="col-sm-5">
                            <select name="NetworkMode" class='form-control'>
                                <option value="bridge">Bridge</option>
                                <option value="host">Host</option>
                                <option value="none">None</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">
                    <i class="material-icons">archive</i>
                    Confirme
                </button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>