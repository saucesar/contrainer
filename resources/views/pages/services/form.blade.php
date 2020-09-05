@csrf
<!-- progressbar -->
<ul id="progressbar">
    <li class="active" id="account"><strong>Basic Params</strong></li>
    <li id="personal"><strong>Task Template</strong></li>
    <li id="payment"><strong>Endpoint Spec</strong></li>
    <li id="confirm"><strong>Finish</strong></li>
</ul> <!-- fieldsets -->
<fieldset>
    <div class="form-card">
        <h2 class="fs-title">Service Information</h2>
        <label for="serviceName">Service Name</label>
        <input type="text" name="serviceName" placeholder="Service name(Required)." class="form-control"
            value="{{ old('serviceName') ?? $service['Spec']['Name'] ?? '' }}" />
        <label for="imageName">Image Name</label>
        <input type="text" name="imageName" placeholder="Image Name.(Required)" class="form-control"
            value="{{ old('imageName') ?? $service['Spec']['TaskTemplate']['ContainerSpec']['Image'] ?? '' }}" />
    </div>
    <input type="button" name="next" class="next action-button" value="Next Step" />
</fieldset>
<fieldset>
    <div class="form-card">
        <h2 class="fs-title">Task Template</h2>
        <h4 class="">Container Spec</h4>
        <label for="env">Environment Variables </label>
        <textarea name="env" cols="30" rows="4" class="form-control"
            placeholder="(Optional)A list of environment variables in the form VAR=value;VAR2=value2">{{ old('env') ? implode(';', $service['Spec']['TaskTemplate']['ContainerSpec']['Env']) : '' }}</textarea>
        <label for="labels">Labels</label>
        <textarea name="labels" cols="30" rows="4" class="form-control"
            placeholder="(Optional)Labels to the service. Ex: L1:VALUE1;L2:VALUE2">{{ old('labels') ?? isset($service) ? implode(';', $service['Spec']['Labels']) : '' }}</textarea>
    </div>
    <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
    <input type="btn btn-primary btn-lg" name="next" class="next action-button" value="Next Step" />
</fieldset>
<fieldset>
    <div class="form-card">
        <h2 class="fs-title">Endpoint Spec</h2>
        <h4 class="">Ports to Expose</h4>
        <label for="ports">Ports to expose</label>
        <textarea name="ports" cols="30" rows="4" class="form-control"
            placeholder="(optional) To use this option do: Protocol, PublishedPort, TargetPort. Ex: tcp,8080,80;tcp,8181,8000">{{ old('ports') ?? $ports ?? '' }}</textarea>
        <h4 class="">DNSConfig</h4>
        <label for="dnsNameServers">Name Servers</label>
        <textarea name="dnsNameServers" cols="30" rows="2" class="form-control"
            placeholder="(Optional)Name Servers. Ex: 8.8.8.8;1.1.1.1;2.2.2.2">{{ old('dnsNameServers') ?? isset($service['Spec']['TaskTemplate']['ContainerSpec']['DNSConfig']['Nameservers']) ? implode(';', $service['Spec']['TaskTemplate']['ContainerSpec']['DNSConfig']['Nameservers']) : '' }}</textarea>
        <input type="text" name="dnsSearch" class="form-control" placeholder="(Optional)DNS Search."
            value="{{ old('dnsSearch') ?? isset($service['Spec']['TaskTemplate']['ContainerSpec']['DNSConfig']['Search']) ? implode(';', $service['Spec']['TaskTemplate']['ContainerSpec']['DNSConfig']['Search']) : '' }}" />
        <input type="text" name="dnsOptions" class="form-control" placeholder="(Optional)DNS Options."
            value="{{ old('dnsOptions') ?? isset($service['Spec']['TaskTemplate']['ContainerSpec']['DNSConfig']['Options']) ? implode(';', $service['Spec']['TaskTemplate']['ContainerSpec']['DNSConfig']['Options']) : '' }}" />
    </div>
    <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
    <input type="btn btn-primary btn-lg" name="next" class="next action-button" value="Next Step" />
</fieldset>
<fieldset>
    <div class="form-card text-center">
        <h2 class="fs-title text-center">Success!</h2><br><br>
        <h4>Clik Run to Create a Service</h4>
        <div class="row justify-content-center">
            <div class="col-3">
                <img src="https://img.icons8.com/color/96/000000/ok--v2.png" class="fit-image">
            </div>
        </div><br><br>
        <div class="row justify-content-center">
            <div class="col-7 text-center">
                <h5>You Have Successfully Configure.</h5>
                <br><br>
                <button type="submit" class="btn btn-primary">Run</button>
            </div>
        </div>
    </div>
</fieldset>