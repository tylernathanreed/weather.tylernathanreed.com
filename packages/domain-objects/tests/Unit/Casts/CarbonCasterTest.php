<?php

use Carbon\Carbon;
use Illuminate\Support\Carbon as SupportCarbon;
use Reedware\DomainObjects\Casts\CarbonCaster;
use Reedware\DomainObjects\Contracts\ObjectResolver;
use Reedware\DomainObjects\Contracts\Reflector;

beforeEach(function () {
    $this->reflector = $this->mock(Reflector::class);
    $this->caster = $this->make(CarbonCaster::class);
});

it('requires a type hint', function () {
    $property = Mockery::mock(ReflectionProperty::class);
    $value = 'foo';

    $this->reflector
        ->shouldReceive('getTypeClass')
        ->with($property)
        ->once()
        ->andReturn(null);
    
    expect($this->caster->appliesTo($property, $value))->toBe(false);
});

it('requires the type class to be a carbon instance', function ($class) {
    $property = Mockery::mock(ReflectionProperty::class);
    $value = 'foo';

    $this->reflector
        ->shouldReceive('getTypeClass')
        ->with($property)
        ->once()
        ->andReturn($class);
    
    expect($this->caster->appliesTo($property, $value))->toBe(true);
})->with([Carbon::class, SupportCarbon::class]);

it('requires the value to be a string', function () {
    $property = Mockery::mock(ReflectionProperty::class);
    $value = 1234;

    $this->reflector
        ->shouldReceive('getTypeClass')
        ->with($property)
        ->once()
        ->andReturn(Carbon::class);

    expect($this->caster->appliesTo($property, $value))->toBe(false);
});

it('parses values into carbon instances', function () {
    $resolver = Mockery::mock(ObjectResolver::class);
    $property = Mockery::mock(ReflectionProperty::class);
    $value = '2023-01-02 12:34:56';
    $array = ['foo' => 'bar'];

    $actual = $this->caster->get($resolver, $property, $value, $array);

    expect($actual)->toBeInstanceOf(Carbon::class);
    expect($actual->toDateTimeString())->toBe('2023-01-02 12:34:56');
});
