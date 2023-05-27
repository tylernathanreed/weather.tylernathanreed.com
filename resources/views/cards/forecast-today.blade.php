@component('components.card')
    @slot('title')
        Today's Forecast for Little Elm, TX
    @endslot
    @include('components.forecast', [
        'items' => [
            [
                'label' => 'Morning',
                'temp' => '73°',
                'condition' => 'Few Showers',
                'rain' => '37%',
                'active' => true
            ],
            [
                'label' => 'Afternoon',
                'temp' => '79°',
                'condition' => 'Cloudy',
                'rain' => '15%'
            ],
            [
                'label' => 'Evening',
                'temp' => '62°',
                'condition' => 'Mostly Cloudy',
                'rain' => '8%'
            ],
            [
                'label' => 'Night',
                'temp' => '67°',
                'condition' => 'Mostly Cloudy',
                'rain' => '15%'
            ],
        ]
    ])
    <div class="mt-4">
        <a class="btn btn-primary" href="{{ route('pages.show', ['page' => 'hourly']) }}">
            Next Hours
        </a>
    </div>
@endcomponent