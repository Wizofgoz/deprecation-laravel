<?php

namespace Wizofgoz\DeprecationLaravel\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Wizofgoz\DeprecationLaravel\DeprecationService;
use Wizofgoz\DeprecationLaravel\ServiceProvider;

class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function getService(): DeprecationService
    {
        return $this->app[DeprecationService::class];
    }

    protected function getPackageProviders($app)
    {
        return [
            ServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }
}
