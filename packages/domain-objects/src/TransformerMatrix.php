<?php

namespace Reedware\DomainObjects;

use Illuminate\Contracts\Container\Container;
use Reedware\DomainObjects\Attributes\TransformedBy;
use Reedware\DomainObjects\Contracts\Reflector;
use Reedware\DomainObjects\Contracts\Transformer;
use Reedware\DomainObjects\Contracts\TransformerFactory;
use Reedware\DomainObjects\Exceptions\TransformerNotFoundException;
use ReflectionClass;

class TransformerMatrix implements TransformerFactory
{
    /**
     * The resolved transformers for each class.
     */
    protected array $transformers = [];

    /**
     * Creates a new transform matrix instance.
     */
    public function __construct(
        protected Container $container,
        protected Reflector $reflector
    ) {
        //
    }

    /**
     * Returns whether or not a transformer for the specified class exists.
     */
    public function exists(string $class): bool
    {
        return ! is_null($this->getTransformer($class));
    }

    /**
     * Returns the transformer, for the specified domain object class.
     */
    public function make(string $class): Transformer
    {
        if (is_null($transformer = $this->getTransformer($class))) {
            throw new TransformerNotFoundException($class);
        }

        return $transformer;
    }

    /**
     * Returns the transformer, if any, for the specified domain object class.
     */
    protected function getTransformer(string $class): ?Transformer
    {
        if (array_key_exists($class, $this->transformers)) {
            return $this->transformers[$class];
        }

        return $this->transformers[$class] = $this->resolveTransformer($class);
    }

    /**
     * Resolves the transformer for the specified domain object class.
     */
    protected function resolveTransformer(string $class): ?Transformer
    {
        $attribute = $this->reflector->getClassAttribute(new ReflectionClass($class), TransformedBy::class);

        if (is_null($attribute?->class)) {
            return null;
        }

        return $this->container->make($attribute->class);
    }
}
