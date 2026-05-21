<?php

namespace App\Services\Aircraft;

use App\Exceptions\UnsupportedAircraftException;

class AircraftLayoutRegistry
{
    public function get(string $type): AircraftLayout
    {
        $layouts = config('aircraft.layouts');

        if (!isset($layouts[$type])) {
            throw new UnsupportedAircraftException($type);
        }

        $layout = $layouts[$type];

        return new AircraftLayout(
            type:        $type,
            minRow:      $layout['rows']['min'],
            maxRow:      $layout['rows']['max'],
            seatLetters: $layout['seat_letters'],
        );
    }

    public function supportedTypes(): array
    {
        return array_keys(config('aircraft.layouts'));
    }
}
