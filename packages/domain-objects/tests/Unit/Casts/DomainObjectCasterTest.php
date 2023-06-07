<?php

use Mockery\MockInterface;
use Reedware\DomainObjects\Casts\DomainObjectCaster;
use Reedware\DomainObjects\Contracts\ObjectResolver;
use Reedware\DomainObjects\Contracts\Reflector;
use Reedware\DomainObjects\DomainObject;
use Reedware\DomainObjects\Tests\Fixtures\Castable;

beforeEach(function () {
    $this->reflector = $this->mock(Reflector::class);
    $this->caster = $this->make(DomainObjectCaster::class);
});

it('requires a type hint', function () {
    $property = Mockery::mock(ReflectionProperty::class);
    $value = ['foo' => 'bar'];

    $this->reflector
        ->shouldReceive('getTypeClass')
        ->with($property)
        ->once()
        ->andReturn(null);
    
    expect($this->caster->appliesTo($property, $value))->toBe(false);
});

it('requires the type class to be a domain object', function () {
    $property = Mockery::mock(ReflectionProperty::class);
    $value = ['foo' => 'bar'];

    $this->reflector
        ->shouldReceive('getTypeClass')
        ->with($property)
        ->once()
        ->andReturn(Castable::class);
    
    expect($this->caster->appliesTo($property, $value))->toBe(true);
});

it('requires the value to be an array', function () {
    $property = Mockery::mock(ReflectionProperty::class);
    $value = 1234;

    $this->reflector
        ->shouldReceive('getTypeClass')
        ->with($property)
        ->once()
        ->andReturn(DomainObject::class);

    expect($this->caster->appliesTo($property, $value))->toBe(false);
});

it('parses values into domain objects', function () {
    /** @var ObjectResolver|MockInterface */
    $resolver = Mockery::mock(ObjectResolver::class);
    $property = Mockery::mock(ReflectionProperty::class);
    $value = ['name' => 'foo'];
    $array = ['foo' => 'bar'];

    $this->reflector
        ->shouldReceive('getTypeClass')
        ->with($property)
        ->once()
        ->andReturn(Castable::class);

    $resolver
        ->shouldReceive('resolve')
        ->with(Castable::class, ['name' => 'foo'])
        ->once()
        ->andReturn($expected = Mockery::mock(Castable::class));

    $actual = $this->caster->get($resolver, $property, $value, $array);

    expect($actual)->toBeInstanceOf(Castable::class);
    expect($actual)->toBe($expected);
});
