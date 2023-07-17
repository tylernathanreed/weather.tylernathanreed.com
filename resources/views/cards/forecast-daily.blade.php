<?php $data = Weather::forecast(5); ?>
<?php $items = collect($data->forecast->forecast_days); ?>

@component('components.card')
    @slot('title')
        Daily Forecast
    @endslot
    @include('components.forecast', [
        'items' => $items->map(function ($forecastDay) {
            return [
                'label' => $label = $forecastDay->date->diffInDays(now()->startOfDay()) == 0
                    ? 'Today'
                    : $forecastDay->date->format('D j'),
                'temp' => round($forecastDay->day->maxtemp_f),
                'temp_low' => round($forecastDay->day->mintemp_f),
                'condition' => $forecastDay->day->condition->text,
                'rain' => $forecastDay->day->daily_chance_of_rain,
                'active' => $label == 'Today'
            ];
        })
    ])
@endcomponent
