<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\PermissionRegistrar;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Run fresh migrations with roles/permissions
        Artisan::call('migrate:fresh --seed');

        $this->app->make(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
