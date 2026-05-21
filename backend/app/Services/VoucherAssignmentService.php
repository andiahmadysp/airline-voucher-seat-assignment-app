<?php

namespace App\Services;

use App\Exceptions\VoucherAlreadyExistsException;
use App\Models\Voucher;

class VoucherAssignmentService
{
    public function __construct(
        private readonly SeatGeneratorService $seatGenerator,
    ) {}

    public function isAlreadyAssigned(string $flightNumber, string $date): bool
    {
        return Voucher::where('flight_number', $flightNumber)
            ->where('flight_date', $date)
            ->exists();
    }

    public function assign(array $data): array
    {
        if ($this->isAlreadyAssigned($data['flightNumber'], $data['date'])) {
            throw new VoucherAlreadyExistsException($data['flightNumber'], $data['date']);
        }

        $seats = $this->seatGenerator->generate($data['aircraft']);

        Voucher::create([
            'crew_name'    => $data['name'],
            'crew_id'      => $data['id'],
            'flight_number'=> $data['flightNumber'],
            'flight_date'  => $data['date'],
            'aircraft_type'=> $data['aircraft'],
            'seat1'        => $seats[0],
            'seat2'        => $seats[1],
            'seat3'        => $seats[2],
        ]);

        return $seats;
    }
}
