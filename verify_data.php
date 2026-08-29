<?php

use App\Models\User;
use App\Models\Customer;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Users in system:\n";
foreach (User::all() as $u) {
    echo "- {$u->name} ({$u->email})\n";
}

echo "\nCustomers in system:\n";
foreach (Customer::all() as $c) {
    echo "- {$c->name} ({$c->email})\n";
}
