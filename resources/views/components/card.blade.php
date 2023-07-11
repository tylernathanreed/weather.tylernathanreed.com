<div class="card shadow my-2">
  <div class="card-body">
    @isset($title)
      <div class="d-flex">
        <h5 class="card-title pe-2">{!! $title !!}</h5>
        @isset($titleAside)
          {!! $titleAside !!}
        @endisset
      </div>
    @endisset
    @isset($subtitle)
      <h6 class="card-subtitle mb-2 text-muted">{!! $subtitle !!}</h6>
    @endisset
    {!! $slot !!}
  </div>
</div>
