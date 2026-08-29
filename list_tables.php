<?php

use Illuminate\Support\Facades\DB;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $tables = DB::select('SHOW TABLES');
    $databaseName = DB::getDatabaseName();
    $columnName = "Tables_in_" . $databaseName;

    echo "Current tables in database '$databaseName':\n";
    foreach ($tables as $table) {
        $name = $table->$columnName;
        echo "- $name\n";
    }
    
    if (empty($tables)) {
        echo "(No tables found)\n";
    }

} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
