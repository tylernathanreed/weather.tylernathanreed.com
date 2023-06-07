<?php

use Reedware\DomainObjects\Contracts\Caster;
use Reedware\DomainObjects\Contracts\CastResolver;
use Reedware\DomainObjects\Contracts\ObjectResolver;
use Reedware\DomainObjects\Domain;
use Reedware\DomainObjects\DomainObject;

beforeEach(function () {
    $this->casts = $this->mock(CastResolver::class);
    $this->resolver = $this->mock(ObjectResolver::class);
    $this->domain = new Domain(
        $this->casts,
        $this->resolver
    );
});

it('resolves using the resolver', function () {
    $object = Mockery::mock(DomainObject::class);

    $this->resolver
        ->shouldReceive('resolve')
        ->with('MyClass', ['foo' => 'bar'])
        ->once()
        ->andReturn($object);
    
    $actual = $this->domain->resolve('MyClass', ['foo' => 'bar']);

    expect($actual)->toBe($object);
});

it('throws when the resolver throws', function () {
    $this->resolver
        ->shouldReceive('resolve')
        ->with('MyClass', ['foo' => 'bar'])
        ->once()
        ->andThrow(new Exception('foo'));
    
    expect(function () {
        $this->domain->resolve('MyClass', ['foo' => 'bar']);
    })->toThrow(function (Exception $e) {
        expect($e->getMessage())->toBe('foo');
    });
});

it('returns null when trying the resolver', function () {
    $this->resolver
        ->shouldReceive('resolve')
        ->with('MyClass', ['foo' => 'bar'])
        ->once()
        ->andThrow(new Exception('foo'));
    
    $actual = $this->domain->tryResolve('MyClass', ['foo' => 'bar']);

    expect($actual)->toBe(null);
});

it('adds casts using the cast resolver', function () {
    $caster = Mockery::mock(Caster::class);

    $this->casts
        ->shouldReceive('add')
        ->with($caster)
        ->once();
    
    $this->domain->addCast($caster);
});

it('replaces casters using the cast resolver', function () {
    $caster = Mockery::mock(Caster::class);

    $this->casts
        ->shouldReceive('replace')
        ->with('MyCaster', $caster)
        ->once();
    
    $this->domain->replaceCast('MyCaster', $caster);
});

it('removes casters using the cast resolver', function () {
    $this->casts
        ->shouldReceive('remove')
        ->with('MyCaster')
        ->once();
    
    $this->domain->removeCast('MyCaster');
});

it('returns the caster resolver', function () {
    expect($this->domain->getCastResolver())->toBe($this->casts);
});

it('returns the object resolver', function () {
    expect($this->domain->getObjectResolver())->toBe($this->resolver);
});
