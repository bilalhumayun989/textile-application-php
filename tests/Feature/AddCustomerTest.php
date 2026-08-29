<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AddCustomerTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_customer_page_loaded()
    {
        $response = $this->get(route('run_balance.customer_create'));
        $response->assertStatus(200);
        $response->assertSee('Add Customer');
    }

    public function test_customer_can_be_created_from_form_page()
    {
        $response = $this->post(route('run_balance.add_customer'), [
            'name' => 'New Client',
            'email' => 'client@example.com',
        ]);

        $response->assertRedirect(route('run_balance.index'));
        $this->assertDatabaseHas('users', [
            'name' => 'New Client',
            'email' => 'client@example.com',
        ]);
    }

    public function test_name_is_required()
    {
        $response = $this->post(route('run_balance.add_customer'), [
            'email' => 'x@example.com',
        ]);

        $response->assertSessionHasErrors('name');
    }
}
