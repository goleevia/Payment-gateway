<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransactionApiTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateTransaction()
    {
        $response = $this->postJson('/api/transactions', [
            'card_number' => '1234567890123456',
            'amount' => 100.00,
            'currency' => 'USD',
            'customer_email' => 'user@example.com',
            'metadata' => [],
        ]);

        $response->assertStatus(201)
                 ->assertJson([
                     'status' => 'approved',
                     'currency' => 'USD',
                 ]);
    }
}
