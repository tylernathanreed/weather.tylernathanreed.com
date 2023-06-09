<?php

use Illuminate\Http\Client\Response as HttpResponse;
use Illuminate\Support\Facades\Http;
use Reedware\Weather\Drivers\WeatherAPI\ResponseResolver;
use Reedware\Weather\Drivers\WeatherApi\Client;
use Reedware\Weather\Drivers\WeatherApi\Requests\AstronomyRequest;
use Reedware\Weather\Drivers\WeatherApi\Requests\CurrentRequest;
use Reedware\Weather\Drivers\WeatherApi\Requests\ForecastRequest;
use Reedware\Weather\Drivers\WeatherApi\Requests\FutureRequest;
use Reedware\Weather\Drivers\WeatherApi\Requests\HistoryRequest;
use Reedware\Weather\Drivers\WeatherApi\Requests\SearchRequest;
use Reedware\Weather\Drivers\WeatherApi\Requests\TimeZoneRequest;
use Reedware\Weather\Drivers\WeatherApi\Responses\AstronomyResponse;
use Reedware\Weather\Drivers\WeatherApi\Responses\CurrentResponse;
use Reedware\Weather\Drivers\WeatherApi\Responses\ErrorResponse;
use Reedware\Weather\Drivers\WeatherApi\Responses\ForecastResponse;
use Reedware\Weather\Drivers\WeatherApi\Responses\FutureResponse;
use Reedware\Weather\Drivers\WeatherApi\Responses\HistoryResponse;
use Reedware\Weather\Drivers\WeatherApi\Responses\SearchResponse;
use Reedware\Weather\Drivers\WeatherApi\Responses\TimeZoneResponse;

beforeEach(function () {
    Http::preventStrayRequests();

    $this->client = new Client(
        http: Http::getFacadeRoot(),
        resolver: $this->resolver = Mockery::mock(ResponseResolver::class),
        apiKey: 'foo',
        baseUrl: 'https://api.example.com/'
    );
});

it('sends requests', function (string $method, string $requestClass, string $responseClass) {
    $url = "https://api.example.com/{$method}?bar=baz&key=foo";
    $baseResponse = Http::response(['qux' => 'quix'], 200);

    Http::fake([
        $url => $baseResponse
    ]);

    $request = Mockery::mock($requestClass);
    $response = Mockery::mock($responseClass);

    $request
        ->shouldReceive('uri')
        ->once()
        ->withNoArgs()
        ->andReturn($method);
    
    $request
        ->shouldReceive('parameters')
        ->once()
        ->withNoArgs()
        ->andReturn(['bar' => 'baz']);
    
    $this->resolver
        ->shouldReceive('resolve')
        ->withArgs(
            fn ($a0) => $a0 === $responseClass,
            fn (HttpResponse $a1) => $a1->json() === ['qux' => 'quix'],
        )
        ->once()
        ->andReturn($response);

    $actual = $this->client->{$method}($request);

    expect($actual)->toBe($response);
})->with([
    ['astronomy', AstronomyRequest::class, AstronomyResponse::class],
    ['forecast', ForecastRequest::class, ForecastResponse::class],
    ['future', FutureRequest::class, FutureResponse::class],
    ['history', HistoryRequest::class, HistoryResponse::class],
    ['current', CurrentRequest::class, CurrentResponse::class],
    ['search', SearchRequest::class, SearchResponse::class],
    ['timeZone', TimeZoneRequest::class, TimeZoneResponse::class]
]);

it('returns errors', function (string $method, string $requestClass, string $responseClass) {
    $url = "https://api.example.com/{$method}?bar=baz&key=foo";
    $baseResponse = Http::response(['qux' => 'quix'], 200);

    Http::fake([
        $url => $baseResponse
    ]);

    $request = Mockery::mock($requestClass);
    $response = Mockery::mock(ErrorResponse::class);

    $request
        ->shouldReceive('uri')
        ->once()
        ->withNoArgs()
        ->andReturn($method);
    
    $request
        ->shouldReceive('parameters')
        ->once()
        ->withNoArgs()
        ->andReturn(['bar' => 'baz']);
    
    $this->resolver
        ->shouldReceive('resolve')
        ->withArgs(
            fn ($a0) => $a0 === $responseClass,
            fn (HttpResponse $a1) => $a1->json() === ['qux' => 'quix'],
        )
        ->once()
        ->andReturn($response);

    $actual = $this->client->{$method}($request);

    expect($actual)->toBe($response);
})->with([
    ['astronomy', AstronomyRequest::class, AstronomyResponse::class],
    ['forecast', ForecastRequest::class, ForecastResponse::class],
    ['future', FutureRequest::class, FutureResponse::class],
    ['history', HistoryRequest::class, HistoryResponse::class],
    ['current', CurrentRequest::class, CurrentResponse::class],
    ['search', SearchRequest::class, SearchResponse::class],
    ['timeZone', TimeZoneRequest::class, TimeZoneResponse::class]
]);