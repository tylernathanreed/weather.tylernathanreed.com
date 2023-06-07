<?php

use Reedware\DomainObjects\Contracts\CastResolver;
use Reedware\DomainObjects\Contracts\KeyResolver;
use Reedware\DomainObjects\Contracts\Reflector;
use Reedware\DomainObjects\DomainObject;
use Reedware\DomainObjects\DomainObjectResolver;

beforeEach(function () {
    $this->reflector = Mockery::mock(Reflector::class);
    $this->keys = Mockery::mock(KeyResolver::class);
    $this->casts = Mockery::mock(CastResolver::class);

    $this->resolver = new DomainObjectResolver(
        $this->reflector,
        $this->keys,
        $this->casts
    );
});

it('resolves when all required properties are present', function () {
    $class = 'MyClass';
    $array = ['prop-1' => 'value1'];

    $properties = [
        Mockery::mock(ReflectionProperty::class),
        Mockery::mock(ReflectionProperty::class)
    ];

    $this->reflector
        ->shouldReceive('getProperties')
        ->with('MyClass')
        ->once()
        ->andReturn($properties);

    $this->reflector
        ->shouldReceive('getName')
        ->with($properties[0])
        ->once()
        ->andReturn('prop1');
    
    $this->reflector
        ->shouldReceive('getName')
        ->with($properties[1])
        ->once()
        ->andReturn('prop2');

    $this->keys
        ->shouldReceive('resolve')
        ->with($properties[0])
        ->once()
        ->andReturn('prop-1');

    $this->keys
        ->shouldReceive('resolve')
        ->with($properties[1])
        ->once()
        ->andReturn('prop-2');
    
    $this->reflector
        ->shouldReceive('isRequired')
        ->with($properties[1])
        ->once()
        ->andReturn(false);

    $this->reflector
        ->shouldReceive('getDefaultValue')
        ->with($properties[1])
        ->once()
        ->andReturn('value2');

    $this->casts
        ->shouldReceive('cast')
        ->with($this->resolver, $properties[0], 'value1', $array)
        ->once()
        ->andReturn('value-1');
    
    $this->casts
        ->shouldReceive('cast')
        ->with($this->resolver, $properties[1], 'value2', $array)
        ->once()
        ->andReturn('value-2');

    $expected = Mockery::mock(DomainObject::class);

    $this->reflector
        ->shouldReceive('newInstance')
        ->with('MyClass', [
            'prop1' => 'value-1',
            'prop2' => 'value-2'
        ])
        ->once()
        ->andReturn($expected);

    $actual = $this->resolver->resolve($class, $array);

    expect($actual)->toBe($expected);
});

it('throws when a required property is missing', function () {
    $class = 'MyClass';
    $array = [];

    $properties = [
        Mockery::mock(ReflectionProperty::class)
    ];

    $this->reflector
        ->shouldReceive('getProperties')
        ->with('MyClass')
        ->once()
        ->andReturn($properties);

    $this->reflector
        ->shouldReceive('getName')
        ->with($properties[0])
        ->once()
        ->andReturn('prop1');

    $this->keys
        ->shouldReceive('resolve')
        ->with($properties[0])
        ->once()
        ->andReturn('prop-1');
    
    $this->reflector
        ->shouldReceive('isRequired')
        ->with($properties[0])
        ->once()
        ->andReturn(true);

    expect(function () use ($class, $array) {
        $this->resolver->resolve($class, $array);
    })->toThrow(function (InvalidArgumentException $e) {
        expect($e->getMessage())->toBe(sprintf(
            'Missing required property [%s] for instance of [%s] in array [%s].',
            'prop-1',
            'MyClass',
            '[]'
        ));
    });
});

it('returns the reflector', function () {
    expect($this->resolver->getReflector())->toBe($this->reflector);
});

it('returns the key resolver', function () {
    expect($this->resolver->getKeyResolver())->toBe($this->keys);
});

it('returns the cast resolver', function () {
    expect($this->resolver->getCastResolver())->toBe($this->casts);
});
