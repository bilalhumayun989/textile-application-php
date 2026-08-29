<?php

namespace Tests\Feature;

use App\Models\Wallet;
use App\Models\WalletEntry;
use App\Models\WalletNet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WalletTest extends TestCase
{
    use RefreshDatabase;

    public function test_wallet_index_and_creation()
    {
        $response = $this->get(route('wallets.index'));
        $response->assertStatus(200);
        $response->assertSee('Wallets');

        $response = $this->post(route('wallets.store'), [
            'name' => 'My Wallet',
        ]);
        $response->assertRedirect(route('wallets.index'));
        $this->assertDatabaseHas('wallets', ['name' => 'My Wallet']);
    }

    public function test_wallet_entry_and_deletion()
    {
        $wallet = Wallet::factory()->create();

        // view wallet page
        $response = $this->get(route('wallets.show', $wallet->id));
        $response->assertStatus(200);
        $response->assertSee($wallet->name);

        // add entry
        $response = $this->post(route('wallets.entry', $wallet->id), [
            'type' => 'credit',
            'amount' => 123.45,
        ]);
        $response->assertRedirect(route('wallets.show', $wallet->id));
        $this->assertDatabaseHas('wallet_entries', ['wallet_id' => $wallet->id, 'amount' => 123.45]);

        $entry = WalletEntry::first();
        // delete entry
        $response = $this->delete(route('wallets.entry.destroy', $entry->id));
        $response->assertRedirect(route('wallets.show', $wallet->id));
        $this->assertDatabaseMissing('wallet_entries', ['id' => $entry->id]);
    }

    public function test_net_calculation_and_history()
    {
        $wallet = Wallet::factory()->create();
        // add two entries
        $wallet->entries()->create(['type'=>'credit','amount'=>100]);
        $wallet->entries()->create(['type'=>'debit','amount'=>30]);

        // route without wallet_id should load
        $response = $this->get(route('wallets.net'));
        $response->assertStatus(200);

        $response = $this->get(route('wallets.net', ['wallet_id' => $wallet->id]));
        $response->assertStatus(200);
        $response->assertSee('Net Calculation');
        $response->assertSeeText('Net: 70.00');
        // also validate received/used text
        $response->assertSeeText('Received: 100.00');
        $response->assertSeeText('Used: 30.00');
        // should persist a record
        $this->assertDatabaseHas('wallet_nets', ['wallet_id' => $wallet->id, 'net_amount' => 70]);

        $net = WalletNet::first();
        // delete net record
        $response = $this->delete(route('wallets.net.destroy', $net->id));
        $response->assertRedirect(route('wallets.net'));
        $this->assertDatabaseMissing('wallet_nets', ['id' => $net->id]);
    }
}
