<?php

use Illuminate\Support\Facades\Artisan;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    echo "Running migration...\n";
    Artisan::call('migrate', ['--force' => true]);
    echo Artisan::output();
    
    echo "Running seed...\n";
    Artisan::call('db:seed', ['--force' => true]);
    echo Artisan::output();
    
    echo "Migration and seeding completed successfully.\n";
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    if (isset($e->previous)) {
        echo "PREVIOUS: " . $e->previous->getMessage() . "\n";
    }
}
