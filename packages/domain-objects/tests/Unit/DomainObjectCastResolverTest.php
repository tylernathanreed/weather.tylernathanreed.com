<?php

use Mockery\MockInterface;
use Reedware\DomainObjects\Casts\CarbonCaster;
use Reedware\DomainObjects\Contracts\Caster;
use Reedware\DomainObjects\Contracts\CastResolver;
use Reedware\DomainObjects\Contracts\ObjectResolver;
use Reedware\DomainObjects\DomainObjectCastResolver;

beforeEach(function () {
    $this->newResolver = function (array $casters): CastResolver {
        return new DomainObjectCastResolver($casters);
    };
});

it('casts using the casters in order', function () {
    foreach (range(0, 2) as $index) {
        /** @var Caster|MockInterface */
        $caster = Mockery::mock(Caster::class);
        $casters[] = $caster;
    }

    $objectResolver = Mockery::mock(ObjectResolver::class);
    $property = Mockery::mock(ReflectionProperty::class);
    $value = 'foo';
    $array = [
        'one' => 'foo',
        'two' => 'bar'
    ];

    $beforeValues = [
        'foo',
        'foo',
        'qux'
    ];

    $afterValues = [
        'foo',
        'qux',
        'quix'
    ];

    $resolver = ($this->newResolver)($casters);

    foreach ($casters as $index => $caster) {
        $caster
            ->shouldReceive('appliesTo')
            ->with($property, $beforeValues[$index])
            ->once()
            ->andReturn($index == 0 ? false : true);
        
        if ($index == 0) {
            $caster->shouldNotReceive('get');
        } else {
            $caster
                ->shouldReceive('get')
                ->with($objectResolver, $property, $beforeValues[$index], $array)
                ->once()
                ->andReturn($afterValues[$index]);
        }
    }

    $actual = $resolver->cast($objectResolver, $property, $value, $array);

    expect($actual)->toBe($afterValues[2]);
});

it('adds casters to the end of the list', function () {
    $casterA = Mockery::mock(Caster::class);
    $casterB = Mockery::mock(Caster::class);

    $resolver = ($this->newResolver)([$casterA]);

    $resolver->add($casterB);

    $actual = $resolver->getCasters();

    expect($actual)->toBe([
        $casterA,
        $casterB
    ]);
});

it('replaces casters in place', function () {
    $casterA = Mockery::mock(Caster::class);
    $casterB = Mockery::mock(CarbonCaster::class);
    $casterC = Mockery::mock(Caster::class);

    $resolver = ($this->newResolver)([
        $casterA, $casterB, $casterC
    ]);

    $casterD = Mockery::mock(Caster::class);

    $resolver->replace(CarbonCaster::class, $casterD);

    $actual = $resolver->getCasters()[1];

    expect($actual)->toBe($casterD);
});

it('removes casters', function () {
    $casterA = Mockery::mock(Caster::class);
    $casterB = Mockery::mock(CarbonCaster::class);
    $casterC = Mockery::mock(Caster::class);

    $resolver = ($this->newResolver)([
        $casterA, $casterB, $casterC
    ]);

    $resolver->remove(CarbonCaster::class);

    $actual = $resolver->getCasters();

    expect($actual[1])->toBe($casterC);
    expect(count($actual))->toBe(2);
});