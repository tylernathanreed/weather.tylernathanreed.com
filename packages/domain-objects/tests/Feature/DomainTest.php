<?php

use Carbon\Carbon;
use Reedware\DomainObjects\Facades\Domain;
use Reedware\DomainObjects\Tests\Fixtures\Enumerable;
use Reedware\DomainObjects\Tests\Fixtures\Featureable;

it('resolves domain objects', function () {
    $object = Domain::resolve(Featureable::class, [
        'name' => 'Foo',
        'description' => 'Foobar',
        'castables' => [
            ['name' => 'foo'],
            ['name' => 'bar'],
            ['name' => 'baz'],
        ],
        'datetime' => '2023-01-02 12:34:56',
        'enum' => 3
    ]);

    expect($object)->toBeInstanceOf(Featureable::class);
    expect($object->name)->toBe('Foo');
    expect($object->notes)->toBe('Foobar');
    expect($object->castables[0]->name)->toBe('foo');
    expect($object->castables[1]->name)->toBe('bar');
    expect($object->castables[2]->name)->toBe('baz');
    expect($object->datetime)->toBeInstanceOf(Carbon::class);
    expect($object->datetime->toDateTimeString())->toBe('2023-01-02 12:34:56');
    expect($object->enum)->toBeInstanceOf(Enumerable::class);
    expect($object->enum)->toBe(Enumerable::THREE);
    expect($object->success)->toBe(true);
});
