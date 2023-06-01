<?php

use Illuminate\Http\Client\Factory;
use Reedware\Weather\Drivers\WeatherApi\Decorator;
use Reedware\Weather\Manager;

beforeEach(function () {
    /** @var Manager */
    $this->manager = $this->container->make(Manager::class);
});

it('gets default instance name', function () {
    $this->mockConfig([
        'weather' => [
            'default' => 'foo'
        ]
    ]);

    expect($this->manager->getDefaultInstance())->toBe('foo');
});

it('sets the default instance name', function () {
    $this->mockConfig([
        'weather' => [
            'default' => 'foo'
        ]
    ]);

    $this->manager->setDefaultInstance('bar');

    expect($this->container->make('config')->get('weather.default'))->toBe('bar');
});

it('gets instance config', function () {
    $this->mockConfig([
        'weather' => [
            'connections' => [
                'foo' => [
                    '<config>'
                ]
            ]
        ]
    ]);

    expect($this->manager->getInstanceConfig('foo'))->toBe(['<config>']);
});

it('creates connections', function () {
    $this->mockConfig([
        'weather' => [
            'connections' => [
                'foo' => [
                    'driver' => 'weatherApi',
                    'key' => 'bar'
                ]
            ]
        ]
    ]);

    $this->mock(Factory::class);

    $connection = $this->manager->connection('foo');

    expect($connection)
        ->toBeInstanceOf(Decorator::class);
});

it('requires an api key for weather api connections', function () {
    $this->mockConfig([
        'weather' => [
            'connections' => [
                'foo' => [
                    'driver' => 'weatherApi'
                ]
            ]
        ]
    ]);

    $this->mock(Factory::class);

    $this->manager->connection('foo');
})->throws(InvalidArgumentException::class, 'Missing api key for WeatherApi driver.');