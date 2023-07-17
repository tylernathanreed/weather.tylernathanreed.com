<?php $data = Weather::history(today()->subDay()); ?>

@component('components.card')
    @slot('title')
      Hourly Weather
    @endslot

    @slot('titleAside')
      - {{ $data->location->name }}, {{ $data->location->region }}
    @endslot

    @foreach ($data->forecast->forecast_days as $forecastDay)
      <?php $date = $forecastDay->date ?>
      <?php $forecast = collect($forecastDay->hours)
        ->map(function ($hour) {
          return [
            'time' => $hour->time->format('g:i a'),
            'temperature' => round($hour->temp_f),
            'condition' => $hour->condition->text,
            'rain' => $hour->chance_of_rain,
            'wind' => $hour->wind_dir . ' ' . round($hour->wind_mph),
            'feels-like' => round($hour->feelslike_f),
            'humidity' => $hour->humidity,
            'uv-index' => round($hour->uv),
            'cloud-cover' => $hour->cloud,
            'rain-amount' => $hour->precip_in,
            'expandable' => true,
            'expanded' => false
          ];
        }); ?>

      <ul class="list-group list-group-flush border-top border-bottom mt-3">
        <li class="list-group-item list-group-item-dark">
          <h5 class="text-dark">{{ $date->format('l, F j') }}</h5>
        </li>
        @foreach ($forecast as $i => $summary)
          <?php $id = 'summary-' . $date->weekday() . '-' . $i; ?>
          <li class="list-group-item {{ ! $summary['expandable'] ? 'list-group-item-secondary text-muted' : '' }}">
            <a
              class="d-flex align-items-center w-100 text-reset text-decoration-none"
              data-bs-toggle="collapse"
              href="#{{ $id }}-details"
              role="button"
              aria-expanded="{{ $summary['expanded'] }} ? 'true' : 'false' }}"
              aria-controls="{{ $id }}-details"
            >
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
              <div style="flex: 0 0 125px" class="ps-2">
                <i class="text-primary fa-solid fa-wind"></i>
                <span>{{ $summary['wind'] }} mph</span>
              </div>
              <div style="flex: 0 0 50px" class="ps-2">
                @if ($summary['expandable'])
                  <div class="text-end">
                    <i class="text-primary fa-solid fa-chevron-down"></i>
                  </div>
                @endif
              </div>
            </a>
            @if ($summary['expandable'])
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
                          <strong>{{ $summary['wind'] }} mph</strong>
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
                          <strong>{{ $summary['rain-amount'] }} in</strong>
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
    @endforeach
@endcomponent
