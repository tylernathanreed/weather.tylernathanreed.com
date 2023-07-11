<?php $data = Weather::forecast(1); ?>
<?php $hours = collect($data->forecast->forecast_days[0]->hours); ?>
<?php $dayTemp = round($hours->where('is_day', 1)->avg('temp_f')); ?>
<?php $nightTemp = round($hours->where('is_day', 0)->avg('temp_f')); ?>

@component('components.card')
    @slot('title')
        {{ $data->location->name}}, {{ $data->location->region }} as of {{ $data->location->localtime->format('g:i a T') }}
    @endslot
    <p class="fs-1">{{ round($data->current->temp_f) }}°</p>
    <div>{{ $data->current->condition->text }}</div>
    <div>Day {{ $dayTemp}}° • Night {{ $nightTemp }}°</div>
@endcomponent
