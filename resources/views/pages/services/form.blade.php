<div class="tab">
<fieldset>
        <h2 class="fs-title">Service Information</h2>
        <label for="serviceName">Service Name</label>
        <input type="text" name="serviceName" class="form-control" value="{{ old('serviceName') ?? $service['Spec']['Name'] ?? '' }}" />
        <label for="imageName">Image Name</label>
        <input type="text" name="imageName" class="form-control"value="{{ old('imageName') ?? $service['Spec']['TaskTemplate']['ContainerSpec']['Image'] ?? '' }}" />
</fieldset>
</div>

<div class="tab">
<fieldset>
    <div class="form-card">
        <h2 class="fs-title">Task Template</h2>
        <h4 class="">Container Spec</h4>
        <label for="env">Environment Variables </label>
        <textarea name="env" cols="30" rows="4" class="form-control"
            placeholder="(Optional)A list of environment variables in the form VAR=value;VAR2=value2">{{isset($service) ? implode(';', $service['Spec']['TaskTemplate']['ContainerSpec']['Env']) : old('env') }}</textarea>
        <label for="labels">Labels</label>
        <textarea name="labels" cols="30" rows="4" class="form-control"
            placeholder="(Optional)Labels to the service. Ex: L1:VALUE1;L2:VALUE2">{{ old('labels') ?? isset($service) ? implode(';', $service['Spec']['Labels']) : '' }}</textarea>
    </div>
</fieldset>
</div>

<div class="tab">
<fieldset>
    <div class="">
        <h2 class="fs-title">Endpoint Spec</h2>
        <h4 class="form-card">Ports to Expose</h4>
        <div class="row">
            <div class="col-4">
                <label for="portProtocol">Protocol</label>
                <select name="portProtocol" class="form-control">
                    <option value="tcp" {{ old('port-protocol') == 'tcp' ? 'selected' : '' }}>TCP</option>
                    <option value="udp" {{ old('port-protocol') == 'udp' ? 'selected' : '' }}>UDP</option>
                </select>
            </div>
            <div class="col-4">
                <label for="publishedPort">Published</label>
                <input type="number" name="publishedPort" class="form-control" value="{{ old('publishedPort') ?? 10000 }}" min="1">
            </div>
            <div class="col-4">
                <label for="targetPort">Target</label>
                <input type="number" name="targetPort" class="form-control" value="{{ old('targetPort') ?? 10000 }}" min="1">
            </div>
        </div>
    </div>
</fieldset>
</div>
<div class="tab">
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
</div>

<div style="overflow:auto;">
  <div style="float:right;">
    <button type="button" class="btn btn-sm btn-info" id="prevBtn" onclick="nextPrev(-1)">Prev</button>
    <button type="button" class="btn btn-sm btn-success" id="nextBtn" onclick="nextPrev(1)">Next</button>
  </div>
</div>

<!-- Circles which indicates the steps of the form: -->
<div style="text-align:center;margin-top:40px;">
  <span class="step"></span>
  <span class="step"></span>
  <span class="step"></span>
  <span class="step"></span>
</div>