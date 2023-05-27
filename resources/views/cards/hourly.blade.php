@component('components.card')
  @slot('title')
    {{ $date->format('l, F j') }}
  @endslot
  <ul class="list-group list-group-flush">
    <?php $forecast = [
      [
        'time' => '8:30 am',
        'temperature' => '73',
        'condition' => 'Few Showers',
        'rain' => '30',
        'wind' => 'SE 5 mph',
        'expandable' => false
      ],
      [
        'time' => '8:45 am',
        'temperature' => '73',
        'condition' => 'Mostly Cloudy',
        'rain' => '18',
        'wind' => 'SE 5 mph',
        'expandable' => false
      ],
      [
        'time' => '9:00 am',
        'temperature' => '74',
        'condition' => 'Cloudy',
        'rain' => '13',
        'wind' => 'SE 6 mph',
        'feels-like' => '74',
        'humidity' => '65',
        'uv-index' => 1,
        'cloud-cover' => 80,
        'rain-amount' => '0 in',
        'expandable' => true,
        'expanded' => true
      ],
      [
        'time' => '10:00 am',
        'temperature' => '77',
        'condition' => 'Cloudy',
        'rain' => '5',
        'wind' => 'SE 5 mph',
        'feels-like' => '77',
        'humidity' => '58',
        'uv-index' => 3,
        'cloud-cover' => 86,
        'rain-amount' => '0 in',
        'expandable' => true,
        'expanded' => false
      ]
    ]; ?>
    @foreach ($forecast as $i => $summary)
      <?php $id = 'summary-' . $date->weekday() . '-' . $i; ?>
      <li class="list-group-item">
        <div class="d-flex align-items-center w-100">
          <div style="flex: 0 0 100px" class="pe-2">
            <span>{{ $summary['time'] }}</span>
          </div>
          <div style="flex: 0 0 100px" class="pe-2">
            <span class="fw-bold fs-5">{{ $summary['temperature'] }}°</span>
          </div>
          <div style="flex: 1 1 auto" class="px-2">
            @include('components.condition-icon', ['condition' => $summary['condition']])
            <span>{{ $summary['condition'] }}</span>
          </div>
          <div style="flex: 0 0 100px" class="ps-2">
            <i class="text-primary fa-solid fa-umbrella"></i>
            <span>{{ $summary['rain'] }}%</span>
          </div>
          <div style="flex: 0 0 100px" class="ps-2">
            <i class="text-primary fa-solid fa-wind"></i>
            <span>{{ $summary['wind'] }} </span>
          </div>
          <div style="flex: 0 0 100px" class="ps-2">
            @if ($summary['expandable'])
              <a
                class="d-block text-end"
                data-bs-toggle="collapse"
                href="#{{ $id }}-details"
                role="button"
                aria-expanded="{{ $summary['expanded'] }} ? 'true' : 'false' }}"
                aria-controls="{{ $id }}-details"
              >
                <i class="fa-solid fa-chevron-down"></i>
              </a>
            @endif
          </div>
        </div>
        @if($summary['expandable'])
          <div id="{{ $id }}-details" class="collapse {{ $summary['expanded'] ? 'show' : '' }}">
            <ul class="list-group mt-2">
              <li class="list-group-item">
                <div class="row">
                  <div class="d-flex col">
                    <div class="me-2">
                      <i class="text-primary fa-solid fa-temperature-half"></i>
                    </div>
                    <div>
                      <div>Feels Like</div>
                      <strong>{{ $summary['feels-like'] }}°</strong>
                    </div>
                  </div>
                  <div class="d-flex col">
                    <div class="me-2">
                      <i class="text-primary fa-solid fa-wind"></i>
                    </div>
                    <div>
                      <div>Wind</div>
                      <strong>{{ $summary['wind'] }}</strong>
                    </div>
                  </div>
                  <div class="d-flex col">
                    <div class="me-2">
                      <i class="text-primary fa-solid fa-droplet"></i>
                    </div>
                    <div>
                      <div>Humidity</div>
                      <strong>{{ $summary['humidity'] }}%</strong>
                    </div>
                  </div>
                </div>
              </li>
              <li class="list-group-item">
                <div class="row">
                  <div class="d-flex col">
                    <div class="me-2">
                      <i class="text-primary fa-solid fa-sun"></i>
                    </div>
                    <div>
                      <div>UV Index</div>
                      <strong>{{ $summary['uv-index'] }} of 10</strong>
                    </div>
                  </div>
                  <div class="d-flex col">
                    <div class="me-2">
                      <i class="text-primary fa-solid fa-cloud"></i>
                    </div>
                    <div>
                      <div>Cloud Cover</div>
                      <strong>{{ $summary['cloud-cover'] }}%</strong>
                    </div>
                  </div>
                  <div class="d-flex col">
                    <div class="me-2">
                      <i class="text-primary fa-solid fa-house-flood-water"></i>
                    </div>
                    <div>
                      <div>Rain Amount</div>
                      <strong>{{ $summary['rain-amount'] }}</strong>
                    </div>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        @endif
      </li>
    @endforeach
  </ul>
@endcomponent