<?php

use Mockery\MockInterface;
use Reedware\DomainObjects\Attributes\From;
use Reedware\DomainObjects\DomainObjectReflector;
use Reedware\DomainObjects\Tests\Fixtures\Reflectable;

beforeEach(function () {
    $this->reflector = new DomainObjectReflector;

    $this->mockParameters = function (
        ReflectionProperty|MockInterface $property,
        array $parameters
    ): array {
        $property
            ->shouldReceive('getDeclaringClass')
            ->withNoArgs()
            ->andReturn(Mockery::mock(ReflectionClass::class, function (MockInterface $mock) use ($parameters) {
                $mock
                    ->shouldReceive('getConstructor')
                    ->withNoArgs()
                    ->andReturn(Mockery::mock(ReflectionMethod::class, function (MockInterface $mock) use ($parameters) {
                        $mock
                            ->shouldReceive('getParameters')
                            ->withNoArgs()
                            ->andReturn($parameters);
                    }));
            }));
        
        return $parameters;
    };

    $this->mockParameter = function (
        ReflectionProperty|MockInterface $property,
        string $name,
        ?Closure $callback = null
    ): ReflectionParameter|MockInterface {
        $parameter = ($this->mockParameters)($property, [
            Mockery::mock(ReflectionParameter::class, function (MockInterface $mock) use ($name) {
                $mock
                    ->shouldReceive('getName')
                    ->withNoArgs()
                    ->once()
                    ->andReturn($name);
            })
        ])[0];

        if (! is_null($callback)) {
            $callback($parameter);
        }

        return $parameter;
    };
});

it('creates a new instance', function () {
    $instance = $this->reflector->newInstance(Reflectable::class, [
        'name' => 'Foo',
        'description' => null
    ]);

    expect($instance)->toBeInstanceOf(Reflectable::class);
    expect($instance->name)->toBe('Foo');
    expect($instance->description)->toBe(null);
    expect($instance->value)->toBe(0);
});

it('throws on instance creation when reflection throws', function () {
    expect(function () {
        $this->reflector->newInstance(Reflectable::class, [
            'name' => 'Foo'
        ]);
    })->toThrow(function (RuntimeException $e) {
        expect($e->getPrevious())->toBeInstanceOf(ArgumentCountError::class);
        expect($e->getMessage())->toBe(sprintf(
            'Failed to create an instance of [%s] due to %s [%s] using parameters [%s].',
            Reflectable::class,
            ArgumentCountError::class,
            sprintf(
                'Too few arguments to function %s::%s(), 1 passed and at least 2 expected',
                Reflectable::class,
                '__construct'
            ),
            json_encode(['name' => 'Foo'])
        ));
    });
});

it('returns public read-only properties', function () {
    $properties = $this->reflector->getProperties(Reflectable::class);

    $names = array_map(function (ReflectionProperty $property) {
        return $property->getName();
    }, $properties);

    expect($names)->toBe([
        'name',
        'description',
        'value',
    ]);
});

it('returns the name of properties', function () {
    $property = Mockery::mock(ReflectionProperty::class, function (MockInterface $mock) {
        $mock
            ->shouldReceive('getName')
            ->withNoArgs()
            ->once()
            ->andReturn('foo');
    });

    expect($this->reflector->getName($property))->toBe('foo');
});

it('returns the type class of properties', function () {
    $propertyA = Mockery::mock(ReflectionProperty::class, function (MockInterface $mock) {
        $mock
            ->shouldReceive('getType')
            ->withNoArgs()
            ->once()
            ->andReturn(null);
    });

    $propertyB = Mockery::mock(ReflectionProperty::class, function (MockInterface $mock) {
        $mock
            ->shouldReceive('getType')
            ->withNoArgs()
            ->once()
            ->andReturn(Mockery::mock(ReflectionType::class, function (MockInterface $mock) {
                $mock
                    ->shouldReceive('getName')
                    ->withNoArgs()
                    ->once()
                    ->andReturn('Foo');
            }));
    });

    expect($this->reflector->getTypeClass($propertyA))->toBe(null);
    expect($this->reflector->getTypeClass($propertyB))->toBe('Foo');
});

it('returns the default value of properties', function () {
    $property = Mockery::mock(ReflectionProperty::class, function (MockInterface $mock) {
        $mock
            ->shouldReceive('hasDefaultValue')
            ->withNoArgs()
            ->once()
            ->andReturn(true);

        $mock
            ->shouldReceive('getDefaultValue')
            ->withNoArgs()
            ->once()
            ->andReturn('bar');
    });

    expect($this->reflector->getDefaultValue($property))->toBe('bar');
});

it('returns the default value of parameters', function () {
    $property = Mockery::mock(ReflectionProperty::class, function (MockInterface $mock) {
        $mock
            ->shouldReceive('hasDefaultValue')
            ->withNoArgs()
            ->once()
            ->andReturn(false);
        
        $mock
            ->shouldReceive('getType')
            ->withNoArgs()
            ->once()
            ->andReturn(null);
        
        $mock
            ->shouldReceive('getName')
            ->withNoArgs()
            ->once()
            ->andReturn('foo');

        ($this->mockParameter)($mock, 'foo', function (MockInterface $mock) {
            $mock
                ->shouldReceive('getDefaultValue')
                ->withNoArgs()
                ->once()
                ->andReturn('bar');
        });
    });

    expect($this->reflector->getDefaultValue($property))->toBe('bar');
});

it('returns null as the default value when the parameter cannot be found', function () {
    $property = Mockery::mock(ReflectionProperty::class, function (MockInterface $mock) {
        $mock
            ->shouldReceive('hasDefaultValue')
            ->withNoArgs()
            ->once()
            ->andReturn(false);
        
        $mock
            ->shouldReceive('getType')
            ->withNoArgs()
            ->once()
            ->andReturn(null);

        ($this->mockParameters)($mock, []);
    });

    expect($this->reflector->getDefaultValue($property))->toBe(null);
});

it(
    'knows that properties with default values or nullable types are not required',
    function ($hasType, $hasDefaultValue, $allowsNull, $hasParameter, $isOptional, $isDefaultValueAvailable) {
        $type = $hasType
            ? Mockery::mock(ReflectionType::class, function (MockInterface $mock) use ($allowsNull) {
                $mock
                    ->shouldReceive('allowsNull')
                    ->withNoArgs()
                    ->andReturn($allowsNull);
            })
            : null;

        /** @var ReflectionProperty|MockInterface */
        $property = Mockery::mock(ReflectionProperty::class);

        $property
            ->shouldReceive('getType')
            ->withNoArgs()
            ->andReturn($type);
        
        $property
            ->shouldReceive('hasDefaultValue')
            ->withNoArgs()
            ->andReturn($hasDefaultValue);
        
        $property
            ->shouldReceive('getName')
            ->withNoArgs()
            ->andReturn('foo');
        
        ($this->mockParameters)($property, array_filter([
            $hasParameter
                ? Mockery::mock(
                    ReflectionParameter::class,
                    function (MockInterface $mock) use ($isOptional, $isDefaultValueAvailable) {
                        $mock
                            ->shouldReceive('isOptional')
                            ->withNoArgs()
                            ->andReturn($isOptional);
                        
                        $mock
                            ->shouldReceive('isDefaultValueAvailable')
                            ->withNoArgs()
                            ->andReturn($isDefaultValueAvailable);
                        
                        $mock
                            ->shouldReceive('getName')
                            ->withNoArgs()
                            ->andReturn('foo');
                    }
                )
                : null
        ]));
        
        $actual = $this->reflector->isRequired($property);
        $expected = ! (
            $hasDefaultValue
            || ($hasType && $allowsNull)
            || ($isOptional && $hasParameter)
            || ($isDefaultValueAvailable && $hasParameter)
        );

        expect($actual)->toBe($expected);
    }
)
    ->with([true, false])
    ->with([true, false])
    ->with([true, false])
    ->with([true, false])
    ->with([true, false])
    ->with([true, false]);

it('returns the constructor parameter for properties', function () {
    $property = Mockery::mock(ReflectionProperty::class, function (MockInterface $mock) {
        $mock
            ->shouldReceive('getName')
            ->withNoArgs()
            ->once()
            ->andReturn('foo');
    });

    $parameter = ($this->mockParameter)($property, 'foo');

    $actual = $this->reflector->getConstructorParameter($property);

    expect($actual)->toBe($parameter);
});

it('returns no constructor parameter for properties that are not constructed', function () {
    $property = Mockery::mock(ReflectionProperty::class);

    ($this->mockParameters)($property, []);

    $actual = $this->reflector->getConstructorParameter($property);

    expect($actual)->toBe(null);
});


it('returns the no attribute for properties without attributes', function () {
    $property = new ReflectionProperty(Reflectable::class, 'name');

    $actual = $this->reflector->getAttribute($property, From::class);

    expect($actual)->toBe(null);
});

it('returns the specified attribute for properties', function () {
    $property = new ReflectionProperty(Reflectable::class, 'description');

    $actualA = $this->reflector->getAttribute($property, From::class);

    expect($actualA)->toBeInstanceOf(From::class);

    $actualB = $this->reflector->getAttribute($property, ArrayOf::class);

    expect($actualB)->toBe(null);
});