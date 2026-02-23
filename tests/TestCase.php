<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * Setup the test environment.
     *
     * Migrates the database and seeds it for each test.
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Migrate the test database
        $this->artisan('migrate:fresh')->run();
    }
}
