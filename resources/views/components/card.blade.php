<div class="card shadow my-2">
  <div class="card-body">
    @isset($title)
      <h5 class="card-title">{!! $title !!}</h5>
    @endisset
    @isset($subtitle)
      <h6 class="card-subtitle mb-2 text-muted">{!! $subtitle !!}</h6>
    @endisset
    {!! $slot !!}
  </div>
</div>