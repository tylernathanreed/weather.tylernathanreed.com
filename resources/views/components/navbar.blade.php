<nav class="navbar navbar-expand-lg bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="/">Weather</a>
    <form class="d-flex" role="search">
      <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-primary" type="submit">
        <i class="fa-solid fa-magnifying-glass"></i>
      </button>
    </form>
    <button
      class="navbar-toggler"
      type="button"
      data-bs-toggle="collapse"
      data-bs-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" 
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <?php $items = [
        [
          'name' => 'Today',
          'href' => route('pages.home')
        ],
        [
          'name' => 'Hourly',
          'href' => route('pages.show', ['page' => 'hourly'])
        ],
        [
          'name' => '10 Day',
          'href' => route('pages.show', ['page' => 'ten-day'])
        ],
        [
          'name' => 'Weekend',
          'href' => route('pages.show', ['page' => 'weekend'])
        ],
        [
          'name' => 'Monthly',
          'href' => route('pages.show', ['page' => 'monthly'])
        ],
        [
          'name' => 'Radar',
          'href' => route('pages.show', ['page' => 'radar'])
        ],
        [
          'name' => 'More Forecasts',
          'items' => [
            [
              'name' => 'Yesterday\'s Weather',
              'href' => route('pages.show', ['page' => 'yesterday'])
            ],
            [
              'name' => 'Air Quality',
              'href' => route('pages.show', ['page' => 'air-quality'])
            ]
          ]
        ]
      ]; ?>
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        @foreach ($items as $item)
          @if (! isset($item['items']))
            <?php $active = request()->fullUrlIs($item['href']); ?>
            <li class="nav-item">
              <a
                class="nav-link {{ $active ? 'active' : ''}}"
                {!! $active ? 'aria-current="page"' : '' !!}
                href="{{ $item['href'] }}"
              >
                  {{ $item['name'] }}
              </a>
            </li>
          @else
            <li class="nav-item dropdown">
              <a
                class="nav-link dropdown-toggle"
                href="#"
                role="button"
                data-bs-toggle="dropdown"
                aria-expanded="false"
              >
                {{ $item['name'] }}
              </a>
              <ul class="dropdown-menu">
                @foreach ($item['items'] as $subitem)
                  <li>
                    <a class="dropdown-item" href="{{ $subitem['href'] }}">
                      {{ $subitem['name'] }}
                    </a>
                  </li>
                @endforeach
              </ul>
            </li>
          @endif
        @endforeach
      </ul>
    </div>
  </div>
</nav>