@component('components.card')
    @slot('title')
        Weather Today in Little Elm, TX
    @endslot
    <div class="row">
        <div class="col">
            <div class="text-center">
                <div class="fs-1">68°</div>
                <div>Feels Like</div>
            </div>
        </div>
        <div class="col">
            <div class="text-center">
                <div>
                    <i class="fa-solid fa-arrow-up"></i>
                    <span>Sunrise 6:23 am</span>
                </div>
                <div>
                    <i class="fa-solid fa-arrow-down"></i>
                    <span>Sunset 8:27 pm</span>
                </div>
            </div>
        </div>
    </div>
    <ul class="list-group list-group-flush mt-4">
        <?php $items = [
            [ 'icon' => 'fa-solid fa-temperature-half',                 'label' => 'High / Low', 'value' => '81°/65°'         ],
            [ 'icon' => 'fa-solid fa-wind',                             'label' => 'Wind',       'value' => '5 mph'           ],
            [ 'icon' => 'fa-solid fa-droplet',                          'label' => 'Humidity',   'value' => '87%'             ],
            [ 'icon' => 'fa-solid fa-hand-holding-droplet',             'label' => 'Dew Point',  'value' => '64°'             ],
            [ 'icon' => 'fa-solid fa-down-left-and-up-right-to-center', 'label' => 'Pressure',   'value' => '29.99 in'        ],
            [ 'icon' => 'fa-solid fa-sun',                              'label' => 'UV Index',   'value' => '0 of 10'         ],
            [ 'icon' => 'fa-solid fa-eye',                              'label' => 'Visibility', 'value' => '10 mi'           ],
            [ 'icon' => 'fa-solid fa-moon',                             'label' => 'Moon Phase', 'value' => 'Waxing Crescent' ]
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