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
                <div class="text-left">
                    <div class="row">
                        <div class="col-10">
                            <label for="Domainname">Domainname</label>
                            <input type="text" name="Domainname" value="{{ old('Domainname') ?? $container_template['Domainname'] }}"class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <h3>Labels</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-5">
                            <label for="LabelKeys[]">KEY</label>
                        </div>
                        <div class="col-5">
                            <label for="">VALUE</label>
                        </div>
                        <div class="col-2">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-10" id="labels">
                            <div class="row">
                                <div class="col-5">
                                    <input type="text" name="LabelKeys[]" class="form-control">
                                </div>
                                <div class="col-5" id="label-values">
                                    <div class="row">
                                        <div class="col-10">
                                            <input type="text" name="LabelValues[]"class="form-control">
                                        </div>
                                        <div class="col-2" id="colBtnRemoveLabel1"></div>
                                    </div>
                                </div>
                            </div>
                            @php( $labelKeys = array_keys($container_template['Labels']) )
                            @for($i = 0; $i < count($container_template['Labels']); $i++)
                            <div class="row">
                                <div class="col-5">
                                    <input type="text" name="LabelKeys[]" value="{{ $labelKeys[$i] }}" class="form-control">
                                </div>
                                <div class="col-5" id="label-values">
                                    <div class="row">
                                        <div class="col-10">
                                            <input type="text" name="LabelValues[]"class="form-control" value="{{ $container_template['Labels'][$labelKeys[$i]] }}">
                                        </div>
                                        <div class="col-2">
                                            <button type="button" class="btn btn-sm btn-link btn-danger" title="Delete the label"
                                                    onclick="deleteElement(this, 4);">X</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endfor
                            </div>
                            <div class="col-2">
                                <button type="button" class="btn btn-sm btn-success" id="buttonAddLabel" onclick="addLabel()">Add</button>
                            </div>
                        </div>
                    </div>
                    <script type="text/javascript">
                    var countLabel = 1;
                    
                    function addLabel() {
                        var field = '<div class="row"><div class="col-5"><input type="text" name="LabelKeys[]" class="form-control">';
                        field+= '</div><div class="col-5" id="label-values"><div class="row"><div class="col-10">';
                        field+= '<input type="text" name="LabelValues[]"class="form-control">';
                        field+= '</div><div class="col-2" id="colBtnRemoveLabel'+(++countLabel)+'"></div></div></div></div>';
                        addAtFirst("#labels", field);
                        addAtFirst("#colBtnRemoveLabel"+(countLabel-1), '<button type="button" class="btn btn-sm btn-link btn-danger" title="Delete the label"onclick="deleteElement(this, 4);">X</button>');
                    }

                    function checkLabels() {
                        var button = document.getElementById('buttonAddLabel');
                        button.disabled = !(checkInputArray("LabelKeys[]") && checkInputArray("LabelValues[]"));
                    }
                        
                    setInterval(checkLabels, 100);
                    </script>
                    <div class="row">
                        <div class="col">
                            <h3>Network</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-10">
                            <label for="NetworkMode">NetworkMode</label>
                            <select name="NetworkMode" class="form-control">
                                <option value="bridge"
                                    {{ $container_template['NetworkMode'] == 'bridge' ? 'selected' : '' }}>Bridge
                                </option>
                                <option value="host"
                                    {{ $container_template['NetworkMode'] == 'host' ? 'selected' : '' }}>Host</option>
                                <option value="none"
                                    {{ $container_template['NetworkMode'] == 'none' ? 'selected' : '' }}>None</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-6">
                            <label for="dns">DNS (Ex: 0.0.0.0)</label>
                        </div>
                        <div class="col-6">
                            <label for="IPAddress">IP Address</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4" id="dns-values">
                            <input type="text" name="dns" class="form-control" value="{{ implode(';', $container_template['Dns']) }}">
                        </div>
                        <div class="col-2">
                        </div>
                        <div class="col-4">
                            <input type="text" name="IPAddress" value="{{ old('IPAddress') ?? $container_template['IPAddress'] }}" class="form-control">
                        </div>
                    </div>
                    <br><br>
                    <div class="row">
                        <div class="col-4">
                            <label for="dnsOptions">DNS Options (Ex: timeout:20)</label>
                        </div>
                        <div class="col-2">
                        </div>
                        <div class="col-4">
                            <label for="IPPrefixLen">IP Prefix Len</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4" id="dnsOpt-values">
                            <div class="row">
                                <div class="col-10">
                                    <input type="text" name="dnsOptions[]" class="form-control">
                                </div>
                                <div class="col-2" id="colBtnRemoveDnsOpt1">
                                </div>
                            </div>
                            @foreach($container_template['DnsOptions'] as $dns)
                                <div class="row">
                                    <div class="col-10">
                                        <input type="text" name="dnsOptions[]" class="form-control" value="{{ $dns }}">
                                    </div>
                                    <div class="col-2">
                                        <button type="button" class="btn btn-sm btn-link btn-danger"onclick='deleteElement(this, 2);'>X</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="col-2">
                            <button class="btn btn-sm btn-success" id="buttonAddDnsOpt" onclick="addDnsOpt();"type="button">Add</button>
                        </div>
                        <script type="text/javascript">
                            var countDnsOpt = 1;
                            function addDnsOpt(){
                                var field = '<div class="row"><div class="col-10"><input type="text" name="dnsOptions[]" class="form-control">';
                                    field+= '</div><div class="col-2" id="colBtnRemoveDnsOpt'+(++countDnsOpt)+'"></div></div>';

                                addAtFirst("#dnsOpt-values", field);
                                addAtFirst("#colBtnRemoveDnsOpt"+(countDnsOpt-1), '<button type="button" class="btn btn-sm btn-link btn-danger"onclick="deleteElement(this, 2);">X</button>');
                            }

                            function checkDnsOpt(){
                                var button = document.getElementById('buttonAddDnsOpt');
                                button.disabled = !checkInputArray('dnsOptions[]');
                            }

                            setInterval(checkDnsOpt, 100);
                        </script>
                        <div class="col-4">
                            <input type="text" name="IPPrefixLen"
                                value="{{ old('IPPrefixLen') ?? $container_template['IPPrefixLen'] }}"class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <h3>Env Variables</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-5">
                            <label for="EnvKeys[]">KEY</label>
                        </div>
                        <div class="col-5">
                            <label for="EnvValues[]">VALUE</label>
                        </div>
                        <div class="col-2">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-10" id="colEnv">
                            <div class="row">
                                <div class="col-5">
                                    <input type="text" name="EnvKeys[]" class="form-control">
                                </div>
                                <div class="col-5">
                                    <input type="text" name="EnvValues[]" class="form-control">
                                </div>
                                <div class="col-2" id="colBtnRemoveEnv1">
                                </div>
                            </div>
                            @foreach($container_template['Env'] as $env)
                                <div class="row">
                                    <div class="col-5">
                                        <input type="text" name="EnvKeys[]" class="form-control" value="{{ explode('=', $env)[0] }}">
                                    </div>
                                    <div class="col-5">
                                        <input type="text" name="EnvValues[]" class="form-control" value="{{ explode('=', $env)[1] }}">
                                    </div>
                                    <div class="col-2">
                                        <button type="button" class="btn btn-sm btn-link btn-danger" onclick='deleteElement(this, 2);'>X</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="col-2">
                            <button class="btn btn-sm btn-success" id="buttonAddEnv" onclick="addEnv();"type="button">Add</button>
                        </div>
                        <script type="text/javascript">
                        var countEnv = 1;

                        function addEnv() {
                            var field = '<div class="row"><div class="col-5"><input type="text" name="EnvKeys[]" class="form-control">';
                                field+= '</div><div class="col-5"><input type="text" name="EnvValues[]" class="form-control"></div>';
                                field+='<div class="col-2" id="colBtnRemoveEnv'+(++countEnv)+'"></div></div>';
                            addAtFirst("#colEnv", field);
                            addAtFirst("#colBtnRemoveEnv"+(countEnv-1), '<button type="button" class="btn btn-sm btn-link btn-danger" onclick="deleteElement(this, 2);">X</button>');
                        }

                        function checkEnvs() {
                            var button = document.getElementById('buttonAddEnv');
                            button.disabled = !(checkInputArray("EnvKeys[]") && checkInputArray("EnvValues[]"));
                        }

                        setInterval(checkEnvs, 100);
                        </script>
                    </div>
                    <div class="row">
                        <div class="col">
                            <h3>Others</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-5">
                            <label for="Memory">Memory(MB) 0 is unlimited</label>
                            <input type="number" name="Memory"
                                value="{{ old('Memory') ?? $container_template['Memory'] }}" class="form-control">
                        </div>
                    </div>
                    <br><br>
                    <div class="row">
                        <div class="col">
                            <input type="checkbox" name="AttachStdin"
                                {{ $container_template['AttachStdin'] ? 'checked' : '' }}>
                            <label for="AttachStdin">AttachStdin</label>
                        </div>
                        <div class="col">
                            <input type="checkbox" name="AttachStdout"
                                {{ $container_template['AttachStdout'] ? 'checked' : '' }}>
                            <label for="AttachStdout">AttachStdout</label>
                        </div>
                        <div class="col">
                            <input type="checkbox" name="AttachStderr"
                                {{ $container_template['AttachStderr'] ? 'checked' : '' }}>
                            <label for="AttachStderr">AttachStderr</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <input type="checkbox" name="OpenStdin"
                                {{ $container_template['OpenStdin'] ? 'checked' : '' }}>
                            <label for="OpenStdin">OpenStdin</label>
                        </div>
                        <div class="col">
                            <input type="checkbox" name="StdinOnce"
                                {{ $container_template['StdinOnce'] ? 'checked' : '' }}>
                            <label for="StdinOnce">StdinOnce</label>
                        </div>
                        <div class="col">
                            <input type="checkbox" name="Tty" {{ $container_template['Tty'] ? 'checked' : '' }}>
                            <label for="Tty">Tty</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <input type="checkbox" name="PublishAllPorts"
                                {{ $container_template['HostConfig']['PublishAllPorts'] ? 'checked' : '' }}>
                            <label for="PublishAllPorts">PublishAllPorts</label>
                        </div>
                        <div class="col">
                            <input type="checkbox" name="Privileged"
                                {{ $container_template['HostConfig']['Privileged'] ? 'checked' : '' }}>
                            <label for="Privileged">Privileged</label>
                        </div>
                        <div class="col"></div>
                    </div>
                    <div class="row">
                        <div class="col-5">
                            <label for="Entrypoint">Entrypoint</label>
                            <input type="text" name="Entrypoint" class="form-control"
                                    value="{{ old('Entrypoint') ?? implode(';',$container_template['Entrypoint']) }}">
                        </div>
                        <div class="col-5">
                            <label for="RestartPolicy">RestartPolicy</label>
                            <select name="RestartPolicy" class="form-control">
                                <option value=""
                                    {{  $container_template['HostConfig']['RestartPolicy']['name'] == '' ? 'selected' : '' }}>
                                    Never</option>
                                <option value="always"
                                    {{  $container_template['HostConfig']['RestartPolicy']['name'] == 'always' ? 'selected' : '' }}>
                                    Always</option>
                                <option value="unless-stopped"
                                    {{ $container_template['HostConfig']['RestartPolicy']['name'] == 'unless-stopped' ? 'selected' : '' }}>
                                    Unless-Stopped</option>
                                <option value="on-failure"
                                    {{ $container_template['HostConfig']['RestartPolicy']['name'] == 'on-failure' ? 'selected' : '' }}>
                                    On-Failure</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <h3>Binds</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-5">
                            <label for="BindSrc[]">Volume-Name</label>
                        </div>
                        <div class="col-5">
                            <label for="BindDest[]">Container-Destiny</label>
                        </div>
                        <div class="col-2">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-5" id="col-bind-src">
                            @php($countBindSrc = 0)
                            <input type="text" name="BindSrc[]" id="bindSrc{{ ++$countBindSrc }}" class="form-control">
                            @if(old('BindSrc[]'))
                                @foreach(old('BindSrc[]') as $bind)
                                    <input type="text" name="BindSrc[]" id="bindSrc{{ ++$countBindSrc }}" class="form-control" value="{{ explode(':', $bind)[0] }}">
                                @endforeach
                            @else
                                @foreach($container_template['HostConfig']['Binds'] as $bind)
                                    <input type="text" name="BindSrc[]" id="bindSrc{{ ++$countBindSrc }}" class="form-control" value="{{ explode(':', $bind)[0] }}">
                                @endforeach
                            @endif
                        </div>
                        <div class="col-5" id="col-bind-dest">
                            @php($countBindDests = 0)
                            <input type="text" name="BindDest[]" id="bindDest{{ ++$countBindDests }}" class="form-control">
                            @if(old('BindDest[]'))
                                @foreach(old('BindDest[]') as $bind)
                                    <div class="row"id="bindDest{{ ++$countBindDests }}">
                                        <div class="col-10">
                                            <input type="text" name="BindDest[]" class="form-control" value="{{ explode(':', $bind)[1] }}">
                                        </div>
                                        <div class="col-2">
                                            <button type="button" class="btn btn-sm btn-link btn-danger"
                                                    onclick='deleteElements(<?= json_encode(['bindDest'.$countBindDests, 'bindSrc'.$countBindDests ]);?>, this);'>
                                                X
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                @foreach($container_template['HostConfig']['Binds'] as $bind)
                                    <div class="row"id="bindDest{{ ++$countBindDests }}">
                                        <div class="col-10">
                                            <input type="text" name="BindDest[]" class="form-control" value="{{ explode(':', $bind)[1] }}">
                                        </div>
                                        <div class="col-2">
                                            <button type="button" class="btn btn-sm btn-link btn-danger"
                                                    onclick='deleteElements(<?= json_encode(['bindDest'.$countBindDests, 'bindSrc'.$countBindDests ]);?>, this);'>
                                                X
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class="col-2">
                            <button class="btn btn-sm btn-success" id="buttonAddBind" onclick="addBind();"type="button">Add</button>
                        </div>
                        <script type="text/javascript">
                        function addBind() {
                            addAtFirst("#col-bind-src", '<input type="text" name="BindSrc[]" class="form-control">');
                            addAtFirst("#col-bind-dest", '<input type="text" name="BindDest[]" class="form-control">');
                        }

                        function checkBinds() {
                            var button = document.getElementById('buttonAddBind');
                            button.disabled = !(checkInputArray("BindSrc[]") && checkInputArray("BindDest[]"));
                        }

                        setInterval(checkBinds, 100);
                        </script>
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