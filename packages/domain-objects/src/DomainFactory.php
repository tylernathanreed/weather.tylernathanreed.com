<?php

namespace Reedware\DomainObjects;

use Illuminate\Contracts\Container\Container;
use Reedware\DomainObjects\Contracts\CastResolver;
use Reedware\DomainObjects\Contracts\Factory;
use Reedware\DomainObjects\Contracts\KeyResolver;
use Reedware\DomainObjects\Contracts\Reflector;
use Reedware\DomainObjects\Contracts\TransformerFactory;

class DomainFactory implements Factory
{
    /**
     * Creates a new manager instance.
     */
    public function __construct(
        protected Container $container
    ) {
        //
    }

    /**
     * Creates and returns a new domain instance.
     */
    public function make(): Domain
    {
        $casts = $this->container->make(CastResolver::class);

        return new Domain(
            casts: $casts,
            resolver: new DomainObjectResolver(
                reflector: $this->container->make(Reflector::class),
                keys: $this->container->make(KeyResolver::class),
                casts: $casts,
                matrix: $this->container->make(TransformerFactory::class)
            )
        );
    }
}
