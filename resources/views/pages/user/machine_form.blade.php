<label>CPU Usage Limit(%)</label>
<select name="cpu_utilizavel" class='custom-select'>
    @for ($i = 25; $i <= 100; $i+=5)
        @if ($machine && $i == $machine->cpu_utilizavel)
            <option value="{{ $i }}" selected>{{ $i }}</option>
        @else
            <option value="{{ $i }}">{{ $i }}</option>
        @endif
    @endfor
</select>
<br>
<br>
<label>RAM Usage Limit (MB)</label>
<select name="ram_utilizavel" class='custom-select'>
    @for ($i = 128; $i <= 1024; $i+=128)
        @if ($machine && $i == $machine->ram_utilizavel)
            <option value="{{ $i }}" selected>{{ $i }}</option>
        @else
            <option value="{{ $i }}">{{ $i }}</option>
        @endif
    @endfor
</select>