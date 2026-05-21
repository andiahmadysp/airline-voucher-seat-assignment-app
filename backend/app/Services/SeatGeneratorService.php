<?php

namespace App\Services;

use App\Services\Aircraft\AircraftLayoutRegistry;

class SeatGeneratorService
{
    public function __construct(
        private readonly AircraftLayoutRegistry $registry,
    )
    {
    }

    public function generate(string $aircraftType, int $count = 3): array
    {
        $layout = $this->registry->get($aircraftType);
        $seats = $layout->allSeats();

        return collect($seats)->random($count)->values()->toArray();
    }
}
