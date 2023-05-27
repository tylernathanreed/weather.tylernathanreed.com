<?php

namespace App\Services\Weather\Drivers\WeatherAPI\DTO\Enums;

enum ErrorCode: int
{
    case API_KEY_NOT_FOUND = 1002;
    case SEARCH_PARAMETER_NOT_FOUND = 1003;
    case INVALID_REQUEST_URL = 1005;
    case LOCATION_NOT_FOUND = 1006;
    case API_KEY_LIMITED_HISTORY = 1008;
    case API_KEY_INVALID = 2006;
    case API_KEY_RATE_LIMITED = 2007;
    case API_KEY_DISABLED = 2008;
    case API_KEY_UNAUTHORIZED = 2009;
    case BULK_INVALID_BODY = 9000;
    case BULK_TOO_MANY_LOCATIONS = 9001;
    case INTERNAL_ERROR = 9999;

    /**
     * Returns the http status code for this error code.
     */
    public function httpStatusCode(): int
    {
        return match ($this) {
            self::API_KEY_NOT_FOUND,
            self::API_KEY_INVALID => 401,

            self::API_KEY_RATE_LIMITED,
            self::API_KEY_DISABLED,
            self::API_KEY_UNAUTHORIZED => 403,

            default => 400
        };
    }

    /**
     * Returns the description for this error code.
     */
    public function description(): string
    {
        return match ($this) {
            self::API_KEY_NOT_FOUND => 'API key not provided.',
            self::SEARCH_PARAMETER_NOT_FOUND => 'Parameter \'q\' not provided.',
            self::INVALID_REQUEST_URL => 'API request url is invalid.',
            self::LOCATION_NOT_FOUND => 'No location found matching parameter \'q\'.',
            self::API_KEY_LIMITED_HISTORY => (
                'API key is limited to get history data. ' .
                'Please check our pricing page and upgrade to higher plan.'
            ),
            self::API_KEY_INVALID => 'API key provided is invalid.',
            self::API_KEY_RATE_LIMITED => 'API key has exceeded calls per month quota.',
            self::API_KEY_DISABLED => 'API key has been disabled.',
            self::API_KEY_UNAUTHORIZED => (
                'API key does not have access to the resource. ' .
                'Please check pricing page for what is allowed in your API subscription plan.'
            ),
            self::BULK_INVALID_BODY => (
                'Json body passed in bulk request is invalid. ' .
                'Please make sure it is valid json with utf-8 encoding.'
            ),
            self::BULK_TOO_MANY_LOCATIONS => (
                'Json body contains too many locations for bulk request. ' .
                'Please keep it below 50 in a single request.'
            ),
            self::INTERNAL_ERROR => 'Internal application error.'
        };
    }
}
