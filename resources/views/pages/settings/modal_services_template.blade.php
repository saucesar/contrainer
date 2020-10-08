<div class="modal" id="modalServices" tabindex="-1" role="dialog" aria-labelledby="modalServicesLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalServicesLabel">Change default template to create services</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {!! Form::open(['route' => 'service-template.update', 'method' => 'put']) !!}
            <div class="modal-body">
                <div class="text-left">
                    <div class="row">
                        <div class="col">
                            <label for="dnsNameservers">DNS Name Servers (Separate with: ';')</label>
                            <textarea name="dnsNameservers" cols="30" rows="4"
                            class="form-control">{{ implode(';', $service_template['TaskTemplate']['ContainerSpec']['DNSConfig']['Nameservers']) }}</textarea>
                        </div>
                        <div class="col">
                            <label for="dnsNameSearch">DNS Search (Separate with: ';')</label>
                            <textarea name="dnsNameSearch" cols="30" rows="4"
                            class="form-control">{{ implode(';', $service_template['TaskTemplate']['ContainerSpec']['DNSConfig']['Search']) }}</textarea>
                        </div>
                        <div class="col">
                            <label for="dnsNameOptions">DNS Options (Separate with: ';')</label>
                            <textarea name="dnsNameOptions" cols="30" rows="4"
                            class="form-control">{{ implode(';', $service_template['TaskTemplate']['ContainerSpec']['DNSConfig']['Options']) }}</textarea>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col">
                            <h4>Resources</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <label for="memoryBytes">Memory Limite (MB)</label>
                            <input type="number" name="memoryBytes" class="form-control" value="{{ $service_template['TaskTemplate']['Resources']['Limits']['MemoryBytes']/(1024*1024) }}">
                        </div>
                        <div class="col-4">
                            <div class="row">
                                <div class="col">
                                    <label for="memoryBytes">Replicas</label>
                                    <input type="number" name="replicas" class="form-control"value="{{ $service_template['Mode']['Replicated']['Replicas'] }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <input type="checkbox" name="tty" {{ $service_template['TaskTemplate']['ContainerSpec']['TTY'] ? 'checked' : '' }}>
                            <label for="tty">TTY</label>
                            <br>
                            <input type="checkbox" name="openStdin" {{ $service_template['TaskTemplate']['ContainerSpec']['OpenStdin'] ? 'checked' : '' }}>
                            <label for="openStdin">OpenStdin</label>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col">
                            <h4>RestartPolicy</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="restartCondition">Condition</label>
                            <select name="restartCondition" class="form-control">
                                <option value="any"{{ $service_template['TaskTemplate']['RestartPolicy']['Condition'] == 'any' ? 'selected' : ''}}>Any</option>
                                <option value="none"{{ $service_template['TaskTemplate']['RestartPolicy']['Condition'] == 'none' ? 'selected' : ''}}>None</option>
                                <option value="on-failure"{{ $service_template['TaskTemplate']['RestartPolicy']['Condition'] == 'on-failure' ? 'selected' : ''}}>On-Failure</option>
                            </select>
                        </div>
                        <div class="col">
                            <label for="restartDelay">Restart Delay (ms)</label>
                            <input type="number" name="restartDelay" class="form-control" value="{{ $service_template['TaskTemplate']['RestartPolicy']['Delay'] }}">
                        </div>
                        <div class="col">
                            <label for="restartCondition">MaxAttempts</label>
                            <input type="number" name="restartMax" class="form-control" value="{{ $service_template['TaskTemplate']['RestartPolicy']['MaxAttempts'] }}">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col">
                            <h4>UpdateConfig</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="parallelism">Parallelism</label>
                            <input type="number" name="parallelism" class="form-control" value="{{ $service_template['UpdateConfig']['Parallelism'] }}">
                        </div>
                        <div class="col">
                            <label for="updateMonitor">Monitor</label>
                            <input type="number" name="updateMonitor" class="form-control" value="{{ $service_template['UpdateConfig']['Monitor'] }}">
                        </div>
                        <div class="col">
                            <label for="maxFailureRatio">MaxFailureRatio</label>
                            <input type="number" name="maxFailureRatio"  class="form-control" value="{{ $service_template['UpdateConfig']['MaxFailureRatio'] }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="updateOrder">Order</label>
                            <select name="updateOrder" class="form-control">
                                <option value="stop-first" {{ $service_template['UpdateConfig']['Order'] == 'stop-first' ? 'selected' : ''}}>Stop-First</option>
                            </select>
                        </div>
                        <div class="col">
                            <label for="parallelism">FailureAction</label>
                            <select name="failureAction" class="form-control">
                                <option value="pause" {{ $service_template['UpdateConfig']['FailureAction'] == 'pause' ? 'selected' : '' }}>Pause</option>
                                <option value="continue" {{ $service_template['UpdateConfig']['FailureAction'] == 'continue' ? 'selected' : '' }}>Continue</option>
                            </select>
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