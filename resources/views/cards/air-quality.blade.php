<?php $data = Weather::current(true); ?>
<?php $aqi = $data->current->air_quality; ?>

@component('components.card')
    @slot('title')
        Today's Air Quality
    @endslot

    @slot('titleAside')
      - {{ $data->location->name }}, {{ $data->location->region }}
    @endslot

    <div class="row">
        <div class="col">
            <div class="text-center">
                50 / Good
            </div>
        </div>
        <div class="col">
            <div class="text-center">
                Primary Pollutant
            </div>
        </div>
    </div>
    <ul class="list-group list-group-flush mt-4">
        <?php $items = [
            [
                'label' => 'PM2.5 (Particulate matter less than 2.5 microns)',
                'metric' => 50,
                'value' => number_format($aqi->pm2_5, 2)
            ],
            [
                'label' => 'CO (Carbon Monoxide)',
                'metric' => 2,
                'value' => number_format($aqi->co, 2)
            ],
            [
                'label' => 'NO2 (Nitrogen Dioxide)',
                'metric' => 6,
                'value' => number_format($aqi->no2, 2)
            ],
            [
                'label' => 'O3 (Ozone)',
                'metric' => 20,
                'value' => number_format($aqi->o3, 2)
            ],
            [
                'label' => 'PM10 (Particulate matter less than 10 microns)',
                'metric' => 23,
                'value' => number_format($aqi->pm10, 2)
            ],
            [
                'label' => 'SO2 (Sulfur Dioxide)',
                'metric' => 1,
                'value' => number_format($aqi->so2, 2)
            ]
        ]; ?>
        @foreach (array_chunk($items, 2) as $chunk)
            <li class="list-group-item">
                <div class="row">
                    @foreach ($chunk as $item)
                        <div class="col d-flex">
                            <div class="me-3">
                                <span>{{ $item['metric'] }}</span>
                            </div>
                            <div class="flex-1">
                                <div>{{ $item['label'] }}</div>
                                <small class="d-block text-muted">
                                    <strong>Good</strong><br/>
                                    {{ $item['value'] }} µg/m3
                                </small>
                            </div>
                        </div>
                    @endforeach
                </div>
            </li>
        @endforeach
    </ul>
@endcomponent
