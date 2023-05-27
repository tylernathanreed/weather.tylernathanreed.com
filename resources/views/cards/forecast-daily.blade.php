@component('components.card')
    @slot('title')
        Daily Forecast
    @endslot
    @include('components.forecast', [
        'items' => [
            [
                'label' => 'Today',
                'temp' => '81°',
                'temp_low' => '65°',
                'condition' => 'Few Showers',
                'rain' => '100%',
                'active' => true
            ],
            [
                'label' => 'Thu 25',
                'temp' => '85°',
                'temp_low' => '64°',
                'condition' => 'Cloudy',
                'rain' => '8%'
            ],
            [
                'label' => 'Fri 26',
                'temp' => '86°',
                'temp_low' => '66°',
                'condition' => 'Cloudy',
                'rain' => '4%'
            ],
            [
                'label' => 'Sat 27',
                'temp' => '87°',
                'temp_low' => '66°',
                'condition' => 'Cloudy',
                'rain' => '1%'
            ],
            [
                'label' => 'Sun 28',
                'temp' => '87°',
                'temp_low' => '68°',
                'condition' => 'Cloudy',
                'rain' => '6%'
            ],
        ]
    ])
    <div class="mt-4">
        <a class="btn btn-primary" href="{{ route('pages.show', ['page' => 'ten-day']) }}">
            Next 10 Days
        </a>
    </div>
@endcomponent