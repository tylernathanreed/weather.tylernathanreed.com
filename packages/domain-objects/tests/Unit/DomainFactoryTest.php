<?php

use Reedware\DomainObjects\Contracts\CastResolver;
use Reedware\DomainObjects\Contracts\KeyResolver;
use Reedware\DomainObjects\Contracts\Reflector;
use Reedware\DomainObjects\Domain;
use Reedware\DomainObjects\DomainFactory;
use Reedware\DomainObjects\DomainObjectResolver;

it('makes domains', function () {
    $casts = $this->mock(CastResolver::class);
    $reflector = $this->mock(Reflector::class);
    $keys = $this->mock(KeyResolver::class);

    $factory = $this->container->make(DomainFactory::class);

    /** @var Domain */
    $domain = $factory->make();

    /** @var DomainObjectResolver */
    $objectResolver = $domain->getObjectResolver();

    expect($domain->getCastResolver())->toBe($casts);

    expect($objectResolver->getReflector())->toBe($reflector);
    expect($objectResolver->getKeyResolver())->toBe($keys);
    expect($objectResolver->getCastResolver())->toBe($casts);
});
