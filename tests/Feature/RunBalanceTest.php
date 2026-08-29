<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RunBalanceTest extends TestCase
{
    use RefreshDatabase;

    public function test_ledger_page_is_accessible_and_displays_customers()
    {
        $user = User::factory()->create(['name' => 'Customer A']);

        $response = $this->get(route('run_balance.index'));

        $response->assertStatus(200);
        $response->assertSee('Customer Ledger');
        $response->assertSee('Customer A');
        // sidebar menu should be present with expected links
        $response->assertSee('Ledger / Run Balance');
        $response->assertSee('Home');
        // delete customer button should also appear (requires shared $customers)
        $response->assertSee('Delete Customer');
    }
}
