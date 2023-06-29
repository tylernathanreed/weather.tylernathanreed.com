<?php $data = Weather::forecast('75252', 1); ?>
<?php $hours = $data->forecast->forecast_days[0]->hours; ?>
<?php $morning = $hours[6]; ?>
<?php $noon = $hours[11]; ?>
<?php $evening = $hours[18]; ?>
<?php $night = $hours[23]; ?>

<?php $items = collect([
    'Morning' => $hours[6],
    'Noon' => $hours[11],
    'Evening' => $hours[18],
    'Night' => $hours[23]
]); ?>

@component('components.card')
    @slot('title')
        Today's Forecast for {{ $data->location->name}}, {{ $data->location->region }}
    @endslot
    @include('components.forecast', [
        'items' => $items->mapWithKeys(function ($hour, $label) {
            return [$label => [
                'label' => $label,
                'temp' => round($hour->temp_f),
                'condition' => $hour->condition->text,
                'rain' => $hour->chance_of_rain,
                'past' => $hour->time->isPast(),
                'active' => true
            ]];
        })
    ])
    <div class="mt-4">
        <a class="btn btn-primary" href="{{ route('pages.show', ['page' => 'hourly']) }}">
            Next Hours
        </a>
    </div>
@endcomponent
