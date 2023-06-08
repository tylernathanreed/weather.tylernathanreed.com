<?php

use Mockery\MockInterface;
use Reedware\DomainObjects\Contracts\DefaultCastersProvider;
use Reedware\DomainObjects\Facades\Domain;
use Reedware\DomainObjects\Domain as DomainService;

it('accesses the factory', function () {
    $expected = $this->mock(DomainService::class);
    $actual = Domain::getFacadeRoot();

    expect($actual)->toBe($expected);
});

it('returns the default casters', function () {
    $this->mock(DefaultCastersProvider::class, function (MockInterface $mock) {
        $mock
            ->shouldReceive('get')
            ->once()
            ->andReturn(['foo']);
    });

    expect(Domain::getDefaultCasters())->toBe(['foo']);
});
