<div class="modal" id="modalContainersService" tabindex="-1" role="dialog" aria-labelledby="modalContainersLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalContainersLabel">Change default template to create containers</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {!! Form::open(['route' => 'container-template.update', 'method' => 'put']) !!}
            <div class="modal-body">
                <div class="text-left">
                    <div class="row">
                        <div class="col">
                            <label for="Domainname">Domainname</label>
                            <input type="text" name="Domainname" value="{{ old('Domainname') ?? $container_template['Domainname'] }}"
                            class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <h3>Labels</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="LabelKeys[]">KEY</label>
                        </div>
                        <div class="col">
                            <label for="">VALUE</label>
                        </div>
                        <div class="col">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col" id="label-keys">
                            <input type="text" name="LabelKeys[]" class="form-control">
                        </div>
                        <div class="col" id="label-values">
                            <input type="text" name="LabelValues[]" class="form-control">
                        </div>
                        <div class="col">
                            <button class="btn btn-success" id="buttonAddLabel" onclick="addLabel();" type="button">ADD</button>
                        </div>
                        <script type="text/javascript">
                            function addLabel(){
                                let divKeys = $("#label-keys");
                                let divValues = $("#label-values");

                                var fieldValue = '<input type="text" name="LabelValues[]" class="form-control">';
                                var fieldKey = '<input type="text" name="LabelKeys[]" class="form-control">';
                                
                                $(divKeys).prepend(fieldKey);
                                $(divValues).prepend(fieldValue);

                                checkLabels();
                            }
                            
                            function checkLabels(){
                                var labelKeys = document.getElementsByName('LabelKeys[]');
                                var labelValues = document.getElementsByName('LabelValues[]');
                                var allFilled = true;

                                for(var i = 0; i<labelKeys.length; i++){
                                    button = document.getElementById('buttonAddLabel');
                                    if(labelKeys[i].value == ''){
                                        allFilled = false;
                                        break;
                                    }
                                }

                                for(var i = 0; i<labelValues.length; i++){
                                    button = document.getElementById('buttonAddLabel');
                                    if(labelValues[i].value == ''){
                                        allFilled = false;
                                        break;
                                    }
                                }

                                button.disabled = !allFilled;
                                console.log(button.disabled);
                            }

                            setInterval(checkLabels, 100);
                        </script>
                    </div>
                    <br><br>
                    <div class="row">
                        <div class="col">
                            <label for="dns">DNS (Ex: 0.0.0.0;1.1.1.1;)</label>
                            <textarea name="dns"cols="30" rows="3" class="form-control" placeholder=""
                            >{{ old('dns') ?? implode(';', $container_template['Dns']) }}</textarea>
                        </div>
                        <div class="col">
                            <label for="dnsOptions">DNS Options (Ex: opt;opt2;)</label>
                            <textarea name="dnsOptions"cols="30" rows="3" class="form-control" placeholder=""
                            >{{ old('dnsOptions') ?? implode(';', $container_template['DnsOptions']) }}</textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="IPAddress">IP Address</label>
                            <input type="text" name="IPAddress" value="{{ old('IPAddress') ?? $container_template['IPAddress'] }}"
                            class="form-control">
                        </div>
                        <div class="col">
                            <label for="IPPrefixLen">IP Prefix Len</label>
                            <input type="text" name="IPPrefixLen" value="{{ old('IPPrefixLen') ?? $container_template['IPPrefixLen'] }}"
                            class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="MacAddress">MacAddress</label>
                            <input type="text" name="MacAddress" value="{{ old('MacAddress') ?? $container_template['MacAddress'] }}"
                            class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="Memory">Memory(MB) 0 is unlimited</label>
                            <input type="number" name="Memory" value="{{ old('Memory') ?? $container_template['Memory'] }}"
                            class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="Memory">Env variables ( Ex: env=value;env2=value2; )</label>
                            <textarea name="env"cols="30" rows="3" class="form-control" placeholder=""
                            >{{ old('Env') ?? implode(';', $container_template['Env']) }}</textarea>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col">
                            <input type="checkbox" name="AttachStdin"{{ $container_template['AttachStdin'] ? 'checked' : '' }}>
                            <label for="AttachStdin">AttachStdin</label>
                        </div>
                        <div class="col">
                            <input type="checkbox" name="AttachStdout"{{ $container_template['AttachStdout'] ? 'checked' : '' }}>
                            <label for="AttachStdout">AttachStdout</label>
                        </div>
                        <div class="col">
                            <input type="checkbox" name="AttachStderr"{{ $container_template['AttachStderr'] ? 'checked' : '' }}>
                            <label for="AttachStderr">AttachStderr</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <input type="checkbox" name="OpenStdin"{{ $container_template['OpenStdin'] ? 'checked' : '' }}>
                            <label for="OpenStdin">OpenStdin</label>
                        </div>
                        <div class="col">
                            <input type="checkbox" name="StdinOnce"{{ $container_template['StdinOnce'] ? 'checked' : '' }}>
                            <label for="StdinOnce">StdinOnce</label>
                        </div>
                        <div class="col">
                            <input type="checkbox" name="Tty"{{ $container_template['Tty'] ? 'checked' : '' }}>
                            <label for="Tty">Tty</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <input type="checkbox" name="PublishAllPorts"{{ $container_template['HostConfig']['PublishAllPorts'] ? 'checked' : '' }}>
                            <label for="PublishAllPorts">PublishAllPorts</label>
                        </div>
                        <div class="col">
                            <input type="checkbox" name="Privileged"{{ $container_template['HostConfig']['Privileged'] ? 'checked' : '' }}>
                            <label for="Privileged">Privileged</label>
                        </div>
                        <div class="col"></div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="NetworkMode">NetworkMode</label>
                            <select name="NetworkMode" class="form-control">
                                <option value="bridge" {{ $container_template['NetworkMode'] == 'bridge' ? 'selected' : '' }}>Bridge</option>
                                <option value="host" {{ $container_template['NetworkMode'] == 'host' ? 'selected' : '' }}>Host</option>
                                <option value="none" {{ $container_template['NetworkMode'] == 'none' ? 'selected' : '' }}>None</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="Entrypoint">Entrypoint ( Ex: value;value2; )</label>
                            <textarea name="Entrypoint"cols="30" rows="3" class="form-control" placeholder=""
                            >{{ old('Entrypoint') ?? implode(';',$container_template['Entrypoint']) }}</textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="RestartPolicy">RestartPolicy</label>
                            <select name="RestartPolicy" class="form-control">
                                <option value="" {{  $container_template['HostConfig']['RestartPolicy']['name'] == '' ? 'selected' : '' }}>Never</option>
                                <option value="always" {{  $container_template['HostConfig']['RestartPolicy']['name'] == 'always' ? 'selected' : '' }}>Always</option>
                                <option value="unless-stopped" {{ $container_template['HostConfig']['RestartPolicy']['name'] == 'unless-stopped' ? 'selected' : '' }}>Unless-Stopped</option>
                                <option value="on-failure" {{ $container_template['HostConfig']['RestartPolicy']['name'] == 'on-failure' ? 'selected' : '' }}>On-Failure</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="Binds">Binds ( Ex: value;value2; )</label>
                            <textarea name="Binds"cols="30" rows="3" class="form-control" placeholder=""
                            >{{ old('Binds') ?? implode(';', $container_template['HostConfig']['Binds']) }}</textarea>
                        </div>
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