<?php $data = Weather::forecast(1); ?>
<?php $hours = collect($data->forecast->forecast_days[0]->hours); ?>

<?php $items = $hours->filter(function ($hour) {
    $delta = $hour->time->diffInHours(now()->startOfHour(), false);

    return $delta >= -4 && $delta <= 0;
}); ?>

@component('components.card')
    @slot('title')
        Hourly Forecast
    @endslot
    @include('components.forecast', [
        'items' => $items->map(function ($hour) {
            $label = $hour->time->diffInHours(now()->startOfHour()) == 0
                ? 'Now'
                : $hour->time->format('g a');

            return [
                'label' => $label,
                'temp' => round($hour->temp_f),
                'condition' => $hour->condition->text,
                'rain' => round($hour->chance_of_rain),
                'active' => $label == 'Now'
            ];
        })
    ])
    <div class="mt-4">
        <a class="btn btn-primary" href="{{ route('pages.show', ['page' => 'hourly']) }}">
            Next 48 Hours
        </a>
    </div>
@endcomponent
