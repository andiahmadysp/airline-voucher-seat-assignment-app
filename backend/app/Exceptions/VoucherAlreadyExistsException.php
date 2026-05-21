<?php

namespace App\Exceptions;

use Exception;

class VoucherAlreadyExistsException extends Exception
{
    public function __construct(string $flightNumber, string $date)
    {
        parent::__construct(
            "Vouchers for flight $flightNumber on $date have already been generated."
        );
    }
}
