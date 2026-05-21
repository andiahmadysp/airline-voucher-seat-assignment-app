<?php

namespace Tests\Feature\Api;

use App\Models\Voucher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VoucherApiTest extends TestCase
{
    use RefreshDatabase;

    // POST /api/check
    public function test_check_returns_false_when_no_voucher_exists(): void
    {
        $response = $this->postJson('/api/check', [
            'flightNumber' => 'GA102',
            'date'         => '2025-07-12',
        ]);

        $response->assertOk()
            ->assertJson(['exists' => false]);
    }

    public function test_check_returns_true_when_voucher_exists(): void
    {
        Voucher::factory()->create([
            'flight_number' => 'GA102',
            'flight_date'   => '2025-07-12',
        ]);

        $response = $this->postJson('/api/check', [
            'flightNumber' => 'GA102',
            'date'         => '2025-07-12',
        ]);

        $response->assertOk()
            ->assertJson(['exists' => true]);
    }

    public function test_check_returns_422_when_flight_number_invalid(): void
    {
        $response = $this->postJson('/api/check', [
            'flightNumber' => 'invalid',
            'date'         => '2025-07-12',
        ]);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['flightNumber']);
    }

    public function test_check_returns_422_when_date_format_wrong(): void
    {
        $response = $this->postJson('/api/check', [
            'flightNumber' => 'GA102',
            'date'         => '12-07-2025', // incorrect format
        ]);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['date']);
    }

    // POST /api/generate
    public function test_generate_returns_3_seats_and_saves_to_db(): void
    {
        $response = $this->postJson('/api/generate', [
            'name'         => 'Sarah',
            'id'           => '98123',
            'flightNumber' => 'GA102',
            'date'         => '2025-07-12',
            'aircraft'     => 'Airbus 320',
        ]);

        $response->assertOk()
            ->assertJsonStructure(['success', 'seats'])
            ->assertJson(['success' => true]);

        $this->assertCount(3, $response->json('seats'));

        $this->assertDatabaseHas('vouchers', [
            'flight_number' => 'GA102',
            'flight_date'   => '2025-07-12',
        ]);
    }

    public function test_generate_returns_409_when_duplicate(): void
    {
        $payload = [
            'name'         => 'Sarah',
            'id'           => '98123',
            'flightNumber' => 'GA102',
            'date'         => '2025-07-12',
            'aircraft'     => 'Airbus 320',
        ];

        $this->postJson('/api/generate', $payload)->assertOk();

        // second request, same date
        $this->postJson('/api/generate', $payload)->assertStatus(409);
    }

    public function test_generate_returns_422_when_aircraft_invalid(): void
    {
        $response = $this->postJson('/api/generate', [
            'name'         => 'Sarah',
            'id'           => '98123',
            'flightNumber' => 'GA102',
            'date'         => '2025-07-12',
            'aircraft'     => 'Boeing 747',
        ]);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['aircraft']);
    }

    public function test_generate_returns_422_when_required_fields_missing(): void
    {
        $response = $this->postJson('/api/generate', []);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['name', 'id', 'flightNumber', 'date', 'aircraft']);
    }

    public function test_different_flights_can_generate_independently(): void
    {
        $base = [
            'name'     => 'Sarah',
            'id'       => '98123',
            'date'     => '2025-07-12',
            'aircraft' => 'Airbus 320',
        ];

        $this->postJson('/api/generate', array_merge($base, ['flightNumber' => 'GA102']))->assertOk();
        $this->postJson('/api/generate', array_merge($base, ['flightNumber' => 'GA103']))->assertOk();

        $this->assertDatabaseCount('vouchers', 2);
    }
}
