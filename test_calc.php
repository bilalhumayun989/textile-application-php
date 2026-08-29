<?php
require __DIR__.'/vendor/autoload.php';
use App\Models\Costing;
$input=[
    'quantity'=>66260,
    'read'=>90,
    'pick'=>66,
    'warp_count'=>58.5,
    'weft_count'=>58.5,
    'width'=>63.5,
    'yarn_warp_rate'=>600,
    'yarn_weft_rate'=>600,
    'conversion_rate'=>0.53,
];
print_r(Costing::calculate($input));
