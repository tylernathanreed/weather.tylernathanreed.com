<?php

use Mockery\MockInterface;
use Reedware\DomainObjects\Attributes\From;
use Reedware\DomainObjects\Contracts\Reflector;
use Reedware\DomainObjects\DomainObjectKeyResolver;

beforeEach(function () {
    $this->resolver = new DomainObjectKeyResolver(
        $this->reflector = Mockery::mock(Reflector::class)
    );
});

it('resolves to the property name when no attribute is present', function () {
    /** @var ReflectionProperty|MockInterface */
    $property = Mockery::mock(ReflectionProperty::class);

    $this->reflector
        ->shouldReceive('getAttribute')
        ->with($property, From::class)
        ->once()
        ->andReturn(null);
    
    $property
        ->shouldReceive('getName')
        ->once()
        ->andReturn('foo');
    
    $actual = $this->resolver->resolve($property);

    expect($actual)->toBe('foo');
});

it('resolves to the attribute key when an attribute is present', function () {

    /** @var ReflectionProperty|MockInterface */
    $property = Mockery::mock(ReflectionProperty::class);

    $this->reflector
        ->shouldReceive('getAttribute')
        ->with($property, From::class)
        ->once()
        ->andReturn(new From('bar'));
    
    $actual = $this->resolver->resolve($property);

    expect($actual)->toBe('bar');
});
