<?php

use Mockery\MockInterface;
use Reedware\DomainObjects\Casts\EnumCaster;
use Reedware\DomainObjects\Contracts\ObjectResolver;
use Reedware\DomainObjects\Contracts\Reflector;
use Reedware\DomainObjects\DomainObject;
use Reedware\DomainObjects\Tests\Fixtures\Castable;
use Reedware\DomainObjects\Tests\Fixtures\Enumerable;

beforeEach(function () {
    $this->reflector = $this->mock(Reflector::class);
    $this->caster = $this->make(EnumCaster::class);
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

it('requires the type class to be an enum', function () {
    $property = Mockery::mock(ReflectionProperty::class);
    $value = 'foo';

    $this->reflector
        ->shouldReceive('getTypeClass')
        ->with($property)
        ->once()
        ->andReturn(Enumerable::class);
    
    expect($this->caster->appliesTo($property, $value))->toBe(true);
});

it('requires the value to be a string or integer', function ($value, $expected) {
    $property = Mockery::mock(ReflectionProperty::class);

    $this->reflector
        ->shouldReceive('getTypeClass')
        ->with($property)
        ->once()
        ->andReturn(Enumerable::class);

    expect($this->caster->appliesTo($property, $value))->toBe($expected);
})->with([
    [1234, true],
    ['foo', true],
    [0.12, false]
]);

it('parses values into enumerables', function () {
    /** @var ObjectResolver|MockInterface */
    $resolver = Mockery::mock(ObjectResolver::class);
    $property = Mockery::mock(ReflectionProperty::class);
    $value = 2;
    $array = ['foo' => 'bar'];

    $this->reflector
        ->shouldReceive('getTypeClass')
        ->with($property)
        ->once()
        ->andReturn(Enumerable::class);

    $actual = $this->caster->get($resolver, $property, $value, $array);

    expect($actual)->toBeInstanceOf(Enumerable::class);
    expect($actual)->toBe(Enumerable::TWO);
});
