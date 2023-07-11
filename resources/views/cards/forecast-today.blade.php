<?php $data = Weather::forecast(1); ?>
<?php $hours = collect($data->forecast->forecast_days[0]->hours); ?>

<?php $items = collect([
    'Morning' => $hours->filter(fn ($h, $i) => $i >= 0 && $i <= 11),
    'Afternoon' => $hours->filter(fn ($h, $i) => $i >= 12 && $i <= 17),
    'Evening' => $hours->filter(fn ($h, $i) => $i >= 18 && $i <= 21),
    'Night' => $hours->filter(fn ($h, $i) => $i >= 22 && $i <= 23)
]); ?>

@component('components.card')
    @slot('title')
        Today's Forecast for {{ $data->location->name }}, {{ $data->location->region }}
    @endslot
    @include('components.forecast', [
        'items' => $items->mapWithKeys(function ($hours, $label) {
            return [$label => [
                'label' => $label,
                'temp' => round($hours->avg('temp_f')),
                'condition' => $hours->first()->condition->text,
                'rain' => round($hours->avg('chance_of_rain')),
                'past' => $hours->last()->time->isPast(),
                'active' => $hours->first()->time->isPast() && $hours->last()->time->isFuture()
            ]];
        })
    ])
    <div class="mt-4">
        <a class="btn btn-primary" href="{{ route('pages.show', ['page' => 'hourly']) }}">
            Next Hours
        </a>
    </div>
@endcomponent
