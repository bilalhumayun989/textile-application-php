<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * Ensure the sqlite testing database file exists before each test run.
     */
    protected function setUp(): void
    {
        parent::setUp();

        if (config('database.default') === 'sqlite') {
            $db = config('database.connections.sqlite.database');
            if ($db && ! file_exists($db)) {
                // create an empty sqlite file
                touch($db);
            }
        }
    }
}
