<?php

use Reedware\Weather\Drivers\WeatherApi\DomainObjectResolver;
use Reedware\Weather\Drivers\WeatherApi\DTO\Location;

beforeEach(function () {
    $this->resolver = new DomainObjectResolver;
});

it('resolves from an array', function () {
    $array = [
        'id' => 4050689,
        'name' => 'Little Elm',
        'region' => 'Texas',
        'country' => 'United States of America',
        'lat' => 33.22,
        'lon' => -96.91,
        'url' => 'little-elm-texas-united-states-of-america'
    ];

    /** @var Location */
    $obj = $this->resolver->resolve(Location::class, $array);

    expect($obj->id)->toBe(4050689);
    expect($obj->name)->toBe('Little Elm');
    expect($obj->region)->toBe('Texas');
    expect($obj->country)->toBe('United States of America');
    expect($obj->lat)->toBe(33.22);
    expect($obj->lon)->toBe(-96.91);
    expect($obj->url)->toBe('little-elm-texas-united-states-of-america');
});