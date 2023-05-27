@switch($condition)
  @case('Few Showers')
    <i class="text-primary fa-solid fa-cloud-rain"></i>
    @break
  @case('Mostly Cloudy')
    <i class="text-primary fa-solid fa-cloud-sun"></i>
    @break
  @case('Cloudy')
    <i class="text-primary fa-solid fa-cloud"></i>
    @break
@endswitch