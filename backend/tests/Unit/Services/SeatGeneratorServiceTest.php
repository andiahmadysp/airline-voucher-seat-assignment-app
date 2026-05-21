<?php

namespace Tests\Unit\Services;

use App\Services\Aircraft\AircraftLayoutRegistry;
use App\Services\SeatGeneratorService;
use Tests\TestCase;

class SeatGeneratorServiceTest extends TestCase
{
    private SeatGeneratorService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new SeatGeneratorService(new AircraftLayoutRegistry());
    }

    public function test_generates_correct_number_of_seats(): void
    {
        $seats = $this->service->generate('ATR');
        $this->assertCount(3, $seats);
    }

    public function test_generated_seats_are_unique(): void
    {
        $seats = $this->service->generate('Airbus 320');
        $this->assertCount(3, array_unique($seats));
    }

    public function test_generated_seats_are_valid_for_atr(): void
    {
        $seats = $this->service->generate('ATR');

        foreach ($seats as $seat) {
            // extract row number dan letter
            preg_match('/^(\d+)([A-F])$/', $seat, $matches);

            $row    = (int) $matches[1];
            $letter = $matches[2];

            $this->assertGreaterThanOrEqual(1, $row);
            $this->assertLessThanOrEqual(18, $row);
            $this->assertContains($letter, ['A', 'C', 'D', 'F']);
        }
    }

    public function test_generated_seats_are_valid_for_airbus(): void
    {
        $seats = $this->service->generate('Airbus 320');

        foreach ($seats as $seat) {
            preg_match('/^(\d+)([A-F])$/', $seat, $matches);

            $row    = (int) $matches[1];
            $letter = $matches[2];

            $this->assertGreaterThanOrEqual(1, $row);
            $this->assertLessThanOrEqual(32, $row);
            $this->assertContains($letter, ['A', 'B', 'C', 'D', 'E', 'F']);
        }
    }

    public function test_atr_never_generates_invalid_letters(): void
    {
        for ($i = 0; $i < 10; $i++) {
            $seats = $this->service->generate('ATR');

            foreach ($seats as $seat) {
                $this->assertDoesNotMatchRegularExpression('/[BE]$/', $seat);
            }
        }
    }

    public function test_throws_exception_for_unsupported_aircraft(): void
    {
        $this->expectException(\App\Exceptions\UnsupportedAircraftException::class);
        $this->service->generate('Boeing 747');
    }
}
