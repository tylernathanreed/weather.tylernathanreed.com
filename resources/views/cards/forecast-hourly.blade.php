@component('components.card')
    @slot('title')
        Hourly Forecast
    @endslot
    @include('components.forecast', [
        'items' => [
            [
                'label' => 'Now',
                'temp' => '68°',
                'condition' => 'Cloudy',
                'rain' => '15%',
                'active' => true
            ],
            [
                'label' => '8 am',
                'temp' => '69°',
                'condition' => 'Cloudy',
                'rain' => '15%'
            ],
            [
                'label' => '9 am',
                'temp' => '71°',
                'condition' => 'Few Showers',
                'rain' => '15%'
            ],
            [
                'label' => '10 am',
                'temp' => '73°',
                'condition' => 'Few Showers',
                'rain' => '37%'
            ],
            [
                'label' => '11 am',
                'temp' => '75°',
                'condition' => 'Few Showers',
                'rain' => '54%'
            ],
        ]
    ])
    <div class="mt-4">
        <a class="btn btn-primary" href="{{ route('pages.show', ['page' => 'hourly']) }}">
            Next 48 Hours
        </a>
    </div>
@endcomponent