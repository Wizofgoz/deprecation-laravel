<?php

declare(strict_types=1);

namespace Wizofgoz\DeprecationLaravel\Tests;

use Carbon\Carbon;
use Wizofgoz\DeprecationLaravel\Deprecated;
use Wizofgoz\DeprecationLaravel\Sunsetted;

class DeprecationServiceTest extends TestCase
{
    /** @test */
    public function it_binds_deprecated_to_container()
    {
        $service = $this->getService();
        $deprecated = Deprecated::new();

        $service->deprecate($deprecated);

        $this->assertEquals($deprecated, $this->app->get(Deprecated::class));
    }

    /** @test */
    public function it_binds_sunsetted_to_container()
    {
        $service = $this->getService();
        $sunsetted = Sunsetted::new(new Carbon());

        $service->sunset($sunsetted);

        $this->assertEquals($sunsetted, $this->app->get(Sunsetted::class));
    }

    /** @test */
    public function when_nothing_set_get_is_null()
    {
        $service = $this->getService();

        $this->assertNull($service->getDeprecated());
        $this->assertNull($service->getSunsetted());
    }

    /** @test */
    public function when_no_date_is_set_isDeprecated_returns_true()
    {
        $service = $this->getService();
        $deprecated = Deprecated::new();

        $service->deprecate($deprecated);

        $this->assertTrue($service->isDeprecated());
    }

    /** @test */
    public function when_date_is_set_isDeprecated_returns_true_if_date_is_in_past()
    {
        $service = $this->getService();
        $deprecated = Deprecated::new()
            ->setDate(Carbon::now()->subYear());

        $service->deprecate($deprecated);

        $this->assertTrue($service->isDeprecated());
    }

    /** @test */
    public function when_date_is_set_isDeprecated_returns_false_if_date_is_in_future()
    {
        $service = $this->getService();
        $deprecated = Deprecated::new()
            ->setDate(Carbon::now()->addYear());

        $service->deprecate($deprecated);

        $this->assertFalse($service->isDeprecated());
    }

    /** @test */
    public function it_is_sunsetted_if_sunsetted_is_set()
    {
        $service = $this->getService();
        $sunsetted = Sunsetted::new(new Carbon());

        $service->sunset($sunsetted);

        $this->assertTrue($service->isSunsetted());

        // Future date
        $sunsetted = Sunsetted::new(Carbon::now()->addYear());

        $service->sunset($sunsetted);

        $this->assertTrue($service->isSunsetted());

        // Past date
        $sunsetted = Sunsetted::new(Carbon::now()->subYear());

        $service->sunset($sunsetted);

        $this->assertTrue($service->isSunsetted());
    }

    /** @test */
    public function it_is_not_deprecated_if_nothing_is_set()
    {
        $this->assertFalse($this->getService()->isDeprecated());
    }

    /** @test */
    public function it_is_not_sunsetted_if_nothing_is_set()
    {
        $this->assertFalse($this->getService()->isSunsetted());
    }
}
