<?php

namespace Reedware\Weather\Drivers\WeatherApi\DTO;

use Reedware\Weather\Drivers\WeatherApi\Attributes\From;
use Reedware\Weather\Drivers\WeatherApi\DTO\Enums\UkDefraIndex;
use Reedware\Weather\Drivers\WeatherApi\DTO\Enums\UsEpaIndex;

class AirQuality extends DTO
{
    /**
     * Creates a new air quality DTO instance.
     */
    public function __construct(
        /** Carbon Monoxide (μg/m3) */
        public readonly float $co,

        /** Ozone (μg/m3) */
        public readonly float $o3,

        /** Nitrogen dioxide (μg/m3) */
        public readonly float $no2,

        /** Sulphur dioxide (μg/m3) */
        public readonly float $so2,

        /** PM2.5 (μg/m3) */
        public readonly float $pm2_5,

        /** PM10 (μg/m3) */
        public readonly float $pm10,

        /** US - EPA standard */
        #[From('us-epa-index')]
        public readonly UsEpaIndex $usEpaIndex,

        /** UK Defra Index */
        #[From('gb-defra-index')]
        public readonly UkDefraIndex $gbDefraIndex
    ) {
        //
    }
}