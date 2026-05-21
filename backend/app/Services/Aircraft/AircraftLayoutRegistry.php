<?php

namespace App\Services\Aircraft;

class AircraftLayoutRegistry
{
    public function get(string $type): AircraftLayout
    {
        $layouts = config('aircraft.layouts');

        if (!isset($layouts[$type])) {
            abort(422, "Aircraft type '$type' is not supported.");
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
