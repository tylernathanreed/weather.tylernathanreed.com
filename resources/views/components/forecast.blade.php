<div class="row">
    @foreach ($items as $item)
        <div class="col text-center {{ ! $loop->last ? 'border-end' : '' }} {{ $item['active'] ?? false ? 'fw-bold' : ''}}">
            <div class="fs-5 ">{{ $item['label'] }}</div>
            <div class="fs-2 text-primary">{{ $item['temp'] }}</div>
            @if (isset($item['temp_low'] ))
                <div class="fs-5">{{ $item['temp_low'] }}</div>
            @endif
            <div class="fs-1">
                @include('components.condition-icon', ['condition' => $item['condition']])
            </div>
            <div>
                <i class="text-primary fa-solid fa-umbrella"></i>
                <span>{{ $item['rain'] }}</span>
            </div>
        </div>
    @endforeach
</div>