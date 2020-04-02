<label>CPU Usage Limit(%)</label>
<select name="cpu_utilizavel" class='custom-select'>
    @for ($i = 25; $i <= 100; $i+=5)
        @if ($selected_cpu && $i == $selected_cpu)
            <option value="{{ $i }}" selected>{{ $i }}</option>
        @else
            <option value="{{ $i }}">{{ $i }}</option>
        @endif
    @endfor
</select>
<br>
<br>
<label>RAM Usage Limit(MB)</label>
<select name="ram_utilizavel" class='custom-select'>
    @for ($i = 128; $i <= 1024; $i+=128)
        @if ($selected_ram && $i == $selected_ram)
            <option value="{{ $i }}" selected>{{ $i }}</option>
        @else
            <option value="{{ $i }}">{{ $i }}</option>
        @endif
    @endfor
</select>
<br>
<br>
<button type="submit" class="btn btn-primary">Save</button>