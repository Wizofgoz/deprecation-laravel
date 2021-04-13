<?php

declare(strict_types=1);

namespace Wizofgoz\DeprecationLaravel;

use Illuminate\Contracts\Foundation\Application;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function register(): void
    {
        $this->registerBindings();
    }

    public function registerBindings(): void
    {
        $this->app->singleton(DeprecationService::class, fn (Application $app) => new DeprecationService($app));
    }
}
