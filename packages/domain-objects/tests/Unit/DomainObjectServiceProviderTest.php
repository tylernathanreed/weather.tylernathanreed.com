<?php

use Mockery\MockInterface;
use Reedware\DomainObjects\Contracts\CastResolver;
use Reedware\DomainObjects\Contracts\DefaultCastersProvider;
use Reedware\DomainObjects\Contracts\Factory;
use Reedware\DomainObjects\Contracts\KeyResolver;
use Reedware\DomainObjects\Contracts\Reflector;
use Reedware\DomainObjects\DefaultCasters;
use Reedware\DomainObjects\Domain;
use Reedware\DomainObjects\DomainFactory;
use Reedware\DomainObjects\DomainObjectCastResolver;
use Reedware\DomainObjects\DomainObjectKeyResolver;
use Reedware\DomainObjects\DomainObjectReflector;

it('registers the domain as a factory result singleton', function () {
    $expected = Mockery::mock(Domain::class);

    $this->mock(Factory::class, function (MockInterface $mock) use ($expected) {
        $mock
            ->shouldReceive('make')
            ->withNoArgs()
            ->once()
            ->andReturn($expected);
    });

    $actualA = $this->make(Domain::class);
    $actualB = $this->make(Domain::class);

    expect($actualA)->toBe($expected);
    expect($actualB)->toBe($expected);
});

it('registers the factory as a singleton', function () {
    $actualA = $this->make(Factory::class);
    $actualB = $this->make(Factory::class);

    expect($actualA)->toBeInstanceOf(Factory::class);
    expect($actualA)->toBeInstanceOf(DomainFactory::class);
    expect($actualA)->toBe($actualB);
});

it('registers the reflector as a singleton', function () {
    $actualA = $this->make(Reflector::class);
    $actualB = $this->make(Reflector::class);

    expect($actualA)->toBeInstanceOf(Reflector::class);
    expect($actualA)->toBeInstanceOf(DomainObjectReflector::class);
    expect($actualA)->toBe($actualB);
});

it('registers the key resolver as a singleton', function () {
    $actualA = $this->make(KeyResolver::class);
    $actualB = $this->make(KeyResolver::class);

    expect($actualA)->toBeInstanceOf(KeyResolver::class);
    expect($actualA)->toBeInstanceOf(DomainObjectKeyResolver::class);
    expect($actualA)->toBe($actualB);
});

it('registers the cast resolver as a binding', function () {
    $actualA = $this->make(CastResolver::class);
    $actualB = $this->make(CastResolver::class);

    expect($actualA)->toBeInstanceOf(CastResolver::class);
    expect($actualA)->toBeInstanceOf(DomainObjectCastResolver::class);

    expect($actualB)->toBeInstanceOf(CastResolver::class);
    expect($actualB)->toBeInstanceOf(DomainObjectCastResolver::class);

    expect($actualA)->not->toBe($actualB);
});

it('registers the default casters provider as a singleton', function () {
    $actualA = $this->make(DefaultCastersProvider::class);
    $actualB = $this->make(DefaultCastersProvider::class);

    expect($actualA)->toBeInstanceOf(DefaultCastersProvider::class);
    expect($actualA)->toBeInstanceOf(DefaultCasters::class);
    expect($actualA)->toBe($actualB);
});
