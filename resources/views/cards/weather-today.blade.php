<?php $data = Weather::forecast(1); ?>
<?php $forecastDay = $data->forecast->forecast_days[0]; ?>
<?php $astro = $forecastDay->astro; ?>
<?php $day = $forecastDay->day; ?>
<?php $hours = collect($forecastDay->hours); ?>
<?php $currentHour = $hours->first(fn ($hour) => $hour->time->diffInHours(now()->startOfHour()) == 0); ?>

@component('components.card')
    @slot('title')
        Weather Today in {{ $data->location->name }}, {{ $data->location->region }}
    @endslot
    <div class="row">
        <div class="col">
            <div class="text-center">
                <div class="fs-1">{{ $currentHour->feelslike_f }}°</div>
                <div>Feels Like</div>
            </div>
        </div>
        <div class="col">
            <div class="text-center">
                <div>
                    <i class="fa-solid fa-arrow-up"></i>
                    <span>Sunrise {{ $astro->sunrise->format('g:i a') }}</span>
                </div>
                <div>
                    <i class="fa-solid fa-arrow-down"></i>
                    <span>Sunset {{ $astro->sunset->format('g:i a') }}</span>
                </div>
            </div>
        </div>
    </div>
    <ul class="list-group list-group-flush mt-4">
        <?php $items = [
            [
                'icon' => 'fa-solid fa-temperature-half',
                'label' => 'High / Low',
                'value' => sprintf(
                    '%s°/%s°',
                    round($day->maxtemp_f),
                    round($day->mintemp_f)
                )
            ],
            [
                'icon' => 'fa-solid fa-wind',
                'label' => 'Wind',
                'value' => round($day->maxwind_mph) . ' mph'
            ],
            [
                'icon' => 'fa-solid fa-droplet',
                'label' => 'Humidity',
                'value' => $day->avghumidity . '%' 
            ],
            [
                'icon' => 'fa-solid fa-hand-holding-droplet',
                'label' => 'Dew Point',
                'value' => round($hours->avg('dewpoint_f')) . '°'
            ],
            [
                'icon' => 'fa-solid fa-down-left-and-up-right-to-center',
                'label' => 'Pressure',
                'value' => round($hours->avg('pressure_in')) . ' in'
            ],
            [
                'icon' => 'fa-solid fa-sun',
                'label' => 'UV Index',
                'value' => round($day->uv) . ' of 10'
            ],
            [
                'icon' => 'fa-solid fa-eye',
                'label' => 'Visibility',
                'value' => round($day->avgvis_miles) . ' mi'
            ],
            [
                'icon' => 'fa-solid fa-moon',
                'label' => 'Moon Phase',
                'value' => $astro->moon_phase
            ]
        ]; ?>
        @foreach (array_chunk($items, 2) as $chunk)
            <li class="list-group-item">
                <div class="row">
                    @foreach ($chunk as $item)
                        <div class="col d-flex">
                            <div>
                                <i class="{{ $item['icon'] }}"></i>
                                <span>{{ $item['label'] }}</span>
                            </div>
                            <div class="ms-auto">
                                <span>{{ $item['value'] }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </li>
        @endforeach
    </ul>
@endcomponent
