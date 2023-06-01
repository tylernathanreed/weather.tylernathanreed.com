<?php

namespace Reedware\Weather\Drivers\WeatherApi\Exceptions;

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
        parent::__construct(
            $response->error->message,
            $response->error->code
        );
    }

    /**
     * Returns the error response.
     */
    public function getResponse(): ErrorResponse
    {
        return $this->response;
    }
}
