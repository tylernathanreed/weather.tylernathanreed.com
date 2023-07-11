<?php

namespace Reedware\Weather\Drivers\WeatherApi\Exceptions;

use Illuminate\Support\Arr;
use Reedware\Weather\Drivers\WeatherApi\Responses\ErrorResponse;
use RuntimeException;

class ErrorResponseException extends RuntimeException
{
    /**
     * Creates a new exception instance.
     */
    public function __construct(
        protected ErrorResponse $response
    ) {
        $message = ! empty($params = $this->getQueryParameters())
            ? $response->error->message . ' (' . json_encode($params) . ')'
            : $response->error->message;

        parent::__construct(
            $message,
            $response->error->code
        );
    }

    /**
     * Returns the query parameters from the initial request.
     */
    public function getQueryParameters(): array
    {
        $query = $this->response->getBaseResponse()?->effectiveUri()?->getQuery();

        if (is_null($query)) {
            return [];
        }

        parse_str($query, $params);

        return Arr::except($params, 'key');
    }

    /**
     * Returns the error response.
     */
    public function getResponse(): ErrorResponse
    {
        return $this->response;
    }
}
