<?php

namespace App\Exceptions;

use Exception;

class UnsupportedAircraftException extends Exception
{
    public function __construct(string $aircraftType)
    {
        parent::__construct("Aircraft type '$aircraftType' is not supported.");
    }
}
