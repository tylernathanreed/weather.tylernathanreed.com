<?php

use Illuminate\Support\Carbon;
use Mockery\MockInterface;
use Reedware\Weather\Drivers\WeatherApi\Client;
use Reedware\Weather\Drivers\WeatherApi\Decorator;
use Reedware\Weather\Drivers\WeatherApi\DTO\Error;
use Reedware\Weather\Drivers\WeatherApi\Exceptions\ErrorResponseException;
use Reedware\Weather\Drivers\WeatherApi\Requests\AstronomyRequest;
use Reedware\Weather\Drivers\WeatherApi\Requests\CurrentRequest;
use Reedware\Weather\Drivers\WeatherApi\Requests\Enums\YesNo;
use Reedware\Weather\Drivers\WeatherApi\Requests\ForecastRequest;
use Reedware\Weather\Drivers\WeatherApi\Requests\FutureRequest;
use Reedware\Weather\Drivers\WeatherApi\Requests\HistoryRequest;
use Reedware\Weather\Drivers\WeatherApi\Requests\Request;
use Reedware\Weather\Drivers\WeatherApi\Requests\SearchRequest;
use Reedware\Weather\Drivers\WeatherApi\Requests\TimeZoneRequest;
use Reedware\Weather\Drivers\WeatherApi\Responses\AstronomyResponse;
use Reedware\Weather\Drivers\WeatherApi\Responses\CurrentResponse;
use Reedware\Weather\Drivers\WeatherApi\Responses\ErrorResponse;
use Reedware\Weather\Drivers\WeatherApi\Responses\ForecastResponse;
use Reedware\Weather\Drivers\WeatherApi\Responses\FutureResponse;
use Reedware\Weather\Drivers\WeatherApi\Responses\HistoryResponse;
use Reedware\Weather\Drivers\WeatherApi\Responses\Response;
use Reedware\Weather\Drivers\WeatherApi\Responses\SearchResponse;
use Reedware\Weather\Drivers\WeatherApi\Responses\TimeZoneResponse;

beforeEach(function () {
    Carbon::setTestNow('2023-06-01');

    $this->decorator = new Decorator(
        $this->client = Mockery::mock(Client::class)
    );

    $this->mockDecoration = function (
        string $method,
        string $requestClass,
        string $responseClass,
        array $expected
    ): Response|MockInterface {
        $response = Mockery::mock($responseClass);

        $this->client
            ->shouldReceive($method)
            ->withArgs(function (Request $request) use ($requestClass, $expected) {
                if (! $request instanceof $requestClass) {
                    return false;
                }

                $properties = (new ReflectionClass($request))->getProperties(
                    ReflectionProperty::IS_PUBLIC
                );

                for ($i = 0; $i < count($properties); $i++) {
                    if ($request->{$properties[$i]->getName()} !== $expected[$i]) {
                        return false;
                    }
                }

                return true;
            })
            ->once()
            ->andReturn($response);
        
        return $response;
    };

    $this->assertDecoration = function (
        string $method,
        string $requestClass,
        string $responseClass,
        array $parameters,
        array $expected
    ): void {
        $response = ($this->mockDecoration)($method, $requestClass, $responseClass, $expected);

        $actual = $this->decorator->{$method}(...$parameters);
    
        expect($actual)->toBe($response);
    };
});

it('decorates astronomy', function (array $parameters, array $expected) {
    ($this->assertDecoration)('astronomy', AstronomyRequest::class, AstronomyResponse::class, $parameters, $expected);
})->with([
    [['foo'], ['foo', '2023-06-01']],
    [['foo', Carbon::parse('2023-06-02')], ['foo', '2023-06-02']]
]);

it('decorates forecast', function (array $parameters, array $expected) {
    ($this->assertDecoration)('forecast', ForecastRequest::class, ForecastResponse::class, $parameters, $expected);
})->with([
    [['foo'], ['foo', 3, YesNo::no, YesNo::no]],
    [['foo', 1], ['foo', 1, YesNo::no, YesNo::no]],
    [['foo', 1, true], ['foo', 1, YesNo::yes, YesNo::no]],
    [['foo', 1, true, true], ['foo', 1, YesNo::yes, YesNo::yes]],
]);

it('decorates future', function (array $parameters, array $expected) {
    ($this->assertDecoration)('future', FutureRequest::class, FutureResponse::class, $parameters, $expected);
})->with([
    [['foo'], ['foo', '2023-06-15']],
    [['foo', Carbon::parse('2023-07-01')], ['foo', '2023-07-01']]
]);

it('decorates history', function (array $parameters, array $expected) {
    ($this->assertDecoration)('history', HistoryRequest::class, HistoryResponse::class, $parameters, $expected);
})->with([
    [['foo'], ['foo', '2023-05-31']],
    [['foo', Carbon::parse('2023-05-01')], ['foo', '2023-05-01']]
]);

it('decorates current', function (array $parameters, array $expected) {
    ($this->assertDecoration)('current', CurrentRequest::class, CurrentResponse::class, $parameters, $expected);
})->with([
    [['foo'], ['foo', YesNo::no]],
    [['foo', true], ['foo', YesNo::yes]],
    [['foo', false], ['foo', YesNo::no]],
]);

it('decorates search', function (array $parameters, array $expected) {
    ($this->assertDecoration)('search', SearchRequest::class, SearchResponse::class, $parameters, $expected);
})->with([
    [['foo'], ['foo']]
]);

it('decorates timeZone', function (array $parameters, array $expected) {
    ($this->assertDecoration)('timeZone', TimeZoneRequest::class, TimeZoneResponse::class, $parameters, $expected);
})->with([
    [['foo'], ['foo']]
]);

it('returns the client', function () {
    expect($this->decorator->getClient())->toBe($this->client);
});

it('throws errors', function (string $method) {
    $response = new ErrorResponse(
        error: new Error(
            code: 12345,
            message: 'This is an exception.'
        )
    );

    $this->client
        ->shouldReceive($method)
        ->andReturn($response);
    
    expect(fn () => $this->decorator->{$method}('foo'))
        ->toThrow(function (ErrorResponseException $e) use ($response) {
            // expect($e->getResponse())->toBe($response);
        });
})->with([
    'astronomy',
    'forecast',
    'future',
    'history',
    'current',
    'search',
    'timeZone'
]);
