@switch($condition)
  @case('Clear')
  @case('Sunny')
    <i class="text-primary fa-solid fa-sun"></i>
    @break
  @case('Overcast')
  @case('Partly cloudy')
    <i class="text-primary fa-solid fa-cloud-sun"></i>
    @break
  @case('Patchy rain possible')
  @case('Light rain shower')
  @case('Few Showers')
    <i class="text-primary fa-solid fa-cloud-rain"></i>
    @break
  @case('Mostly Cloudy')
    <i class="text-primary fa-solid fa-cloud-sun"></i>
    @break
  @case('Cloudy')
    <i class="text-primary fa-solid fa-cloud"></i>
    @break
  @case('Patchy light rain with thunder')
  @case('Thundery outbreaks possible')
    <i class="text-primary fa-solid fa-cloud-bolt"></i>
    @break
@endswitch
