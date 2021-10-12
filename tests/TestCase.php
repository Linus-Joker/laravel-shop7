<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function initDatabase()
    {
        //call artisan migrate and seed
        Artisan::call('migrate:fresh --seed --env=testing');
    }

    protected function resetDatabase()
    {
        //resetDatabase
    }
}
