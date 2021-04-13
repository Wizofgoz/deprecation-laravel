<?php

declare(strict_types=1);

namespace Wizofgoz\DeprecationLaravel\Tests\Unit;

use Carbon\Carbon;
use Illuminate\Http\Response;
use PHPUnit\Framework\TestCase;
use Wizofgoz\DeprecationLaravel\Sunsetted;

class SunsettedTest extends TestCase
{
    /** @test */
    public function it_creates_a_new_sunset()
    {
        $sunset = Sunsetted::new(new Carbon());

        $this->assertInstanceOf(Sunsetted::class, $sunset);
    }

    /** @test */
    public function it_sets_its_date()
    {
        $sunset = Sunsetted::new(new Carbon());
        $date = new Carbon('2021-01-01 00:00:00');

        $sunset->setDate($date);

        $this->assertEquals($date, $sunset->getDate());
    }

    /** @test */
    public function it_applies_to_response_object()
    {
        $response = new Response();

        $date = new Carbon('2021-01-01 00:00:00');
        $sunset = Sunsetted::new($date);

        $sunset->apply($response);

        $this->assertTrue($response->headers->has(Sunsetted::HEADER));
        $this->assertEquals($date->toRfc7231String(), $response->headers->get(Sunsetted::HEADER));
    }
}
