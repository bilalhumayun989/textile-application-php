<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Customer;
use App\Models\CustomerTransaction;
use App\Models\Wallet;
use App\Models\WalletEntry;
use App\Models\WalletNet;
use App\Models\Bank;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class EncryptExistingData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:encrypt-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Encrypt existing plain-text data in the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $this->info('Starting data encryption process...');

            // 1. Customers
            $this->encryptModel(Customer::class, ['name', 'email', 'phone', 'address', 'contact_info']);

            // 2. Wallets
            $this->encryptModel(Wallet::class, ['name', 'email', 'phone']);

            // 3. Wallet Entries
            $this->encryptModel(WalletEntry::class, ['amount', 'description', 'payment_method']);

            // 4. Customer Transactions
            $this->encryptModel(CustomerTransaction::class, ['debit', 'credit', 'balance', 'description']);

            // 5. Wallet Nets
            $this->encryptModel(WalletNet::class, ['received_total', 'used_total', 'net_amount', 'focus']);

            // 6. Banks
            $this->encryptModel(Bank::class, ['balance']);

            $this->info('Encryption complete!');
        } catch (\Exception $e) {
            $this->error('CRITICAL ERROR: ' . $e->getMessage());
            $this->error($e->getTraceAsString());
        }
    }

    private function encryptModel($modelClass, $fields)
    {
        $tableName = (new $modelClass)->getTable();
        $this->comment("Processing table: $tableName...");
        
        $records = \Illuminate\Support\Facades\DB::table($tableName)->get();
        $count = 0;

        foreach ($records as $record) {
            $updateData = [];
            foreach ($fields as $field) {
                $rawValue = $record->{$field};
                if (is_null($rawValue) || $rawValue === '') continue;

                try {
                    // Check if already encrypted
                    Crypt::decryptString($rawValue);
                } catch (DecryptException $e) {
                    // Not encrypted, so encrypt it
                    $updateData[$field] = Crypt::encryptString($rawValue);
                }
            }

            if (!empty($updateData)) {
                \Illuminate\Support\Facades\DB::table($tableName)
                    ->where('id', $record->id)
                    ->update($updateData);
                $count++;
            }
        }

        $this->info("Updated $count records in $tableName.");
    }
}
