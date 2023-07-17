<?php

namespace Reedware\Weather;

use Closure;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use RuntimeException;
use Stringable;

class Location implements Stringable
{
    /**
     * The location being searched.
     */
    protected ?string $q = null;

    /**
     * The driver specific resolver.
     */
    protected ?Closure $resolver;

    /**
     * Creates a new location instance.
     */
    public function __construct(
        protected Request $request,
        protected Session $session,
        protected string $fallbackLocation
    ) {
        //
    }

    /**
     * Sets the location being searched.
     */
    public function set(string $q): void
    {
        $this->q = $q;
    }

    /**
     * Returns the location being searched.
     */
    public function getValue(): string
    {
        return $this->q ??= $this->resolve();
    }

    /**
     * Sets the resolver to use.
     */
    public function resolveUsing(Closure $callback): void
    {
        $this->resolver = $callback;
    }

    /**
     * Resolves the location being searched.
     */
    protected function resolve(): string
    {
        if ($this->request->has('q')) {
            return $this->request->input('q');
        }

        if ($this->session->has('q')) {
            return $this->session->get('q');
        }

        if (is_null($this->resolver)) {
            throw new RuntimeException('Resolver not defined.');
        }

        return ($this->resolver)($this->request->ip(), $this->fallbackLocation);
    }

    /**
     * Returns the location being searched.
     */
    public function __toString(): string
    {
        return $this->getValue();
    }
}
