<?php

use Mockery\MockInterface;
use Reedware\DomainObjects\Attributes\ArrayOf;
use Reedware\DomainObjects\Casts\DomainObjectArrayCaster;
use Reedware\DomainObjects\Contracts\ObjectResolver;
use Reedware\DomainObjects\Contracts\Reflector;
use Reedware\DomainObjects\Tests\Fixtures\Castable;

beforeEach(function () {
    $this->reflector = $this->mock(Reflector::class);
    $this->caster = $this->make(DomainObjectArrayCaster::class);
});

it('requires an ArrayOf attribute', function () {
    $property = Mockery::mock(ReflectionProperty::class);
    $value = ['foo' => 'bar'];

    $this->reflector
        ->shouldReceive('getAttribute')
        ->with($property, ArrayOf::class)
        ->once()
        ->andReturn(null);
    
    expect($this->caster->appliesTo($property, $value))->toBe(false);
});

it('requires the ArrayOf attribute to wrap a domain object', function () {
    $property = Mockery::mock(ReflectionProperty::class);
    $value = ['foo' => 'bar'];

    $this->reflector
        ->shouldReceive('getAttribute')
        ->with($property, ArrayOf::class)
        ->once()
        ->andReturn(new ArrayOf(Castable::class));
    
    expect($this->caster->appliesTo($property, $value))->toBe(true);
});

it('requires the value to be an array', function () {
    $property = Mockery::mock(ReflectionProperty::class);
    $value = 1234;

    $this->reflector
        ->shouldReceive('getAttribute')
        ->with($property, ArrayOf::class)
        ->once()
        ->andReturn(new ArrayOf(Castable::class));

    expect($this->caster->appliesTo($property, $value))->toBe(false);
});

it('parses values into an array of domain objects', function () {
    /** @var ObjectResolver|MockInterface */
    $resolver = Mockery::mock(ObjectResolver::class);
    $property = Mockery::mock(ReflectionProperty::class);
    $value = [['name' => 'foo'], ['name' => 'bar']];
    $array = ['foo' => 'bar'];

    $this->reflector
        ->shouldReceive('getAttribute')
        ->with($property, ArrayOf::class)
        ->once()
        ->andReturn(new ArrayOf(Castable::class));

    $resolver
        ->shouldReceive('resolve')
        ->with(Castable::class, ['name' => 'foo'])
        ->once()
        ->andReturn($expectedA = Mockery::mock(Castable::class));

    $resolver
        ->shouldReceive('resolve')
        ->with(Castable::class, ['name' => 'bar'])
        ->once()
        ->andReturn($expectedB = Mockery::mock(Castable::class));

    $actual = $this->caster->get($resolver, $property, $value, $array);

    expect($actual)->toBe([$expectedA, $expectedB]);
});
