<?php

namespace App\Services\Aircraft;

class AircraftLayout
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public readonly string $type,
        public readonly int $minRow,
        public readonly int $maxRow,
        public readonly array $seatLetters,
    )
    {
        //
    }

    public function allSeats(): array
    {
        $seats = [];

        for ($row = $this->minRow; $row <= $this->maxRow; $row++) {
            foreach ($this->seatLetters as $letter) {
                $seats[] = $row . $letter;
            }
        }

        return $seats;
    }
}
