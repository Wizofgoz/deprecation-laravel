<?php

declare(strict_types=1);

namespace Wizofgoz\DeprecationLaravel\Tests\Unit;

use Carbon\Carbon;
use Illuminate\Http\Response;
use PHPUnit\Framework\TestCase;
use Wizofgoz\DeprecationLaravel\Deprecated;
use Wizofgoz\DeprecationLaravel\Links\Link;

class DeprecatedTest extends TestCase
{
    /** @test */
    public function it_creates_a_new_deprecated()
    {
        $deprecated = Deprecated::new();

        $this->assertInstanceOf(Deprecated::class, $deprecated);
    }

    /** @test */
    public function it_applies_to_response_object()
    {
        $response = new Response();

        $deprecated = Deprecated::new();

        $deprecated->apply($response);

        $this->assertTrue($response->headers->has(Deprecated::HEADER));
        $this->assertEquals('true', $response->headers->get(Deprecated::HEADER));
    }

    /** @test */
    public function it_applies_to_response_with_date()
    {
        $response = new Response();

        $date = new Carbon('2020-01-01 00:00:00');
        $deprecated = Deprecated::new()
            ->setDate($date);

        $deprecated->apply($response);

        $this->assertTrue($response->headers->has(Deprecated::HEADER));
        $this->assertEquals($date->toRfc7231String(), $response->headers->get(Deprecated::HEADER));
    }

    /** @test */
    public function it_applies_links_to_response()
    {
        $response = new Response();
        $link = $this->createMock(Link::class);
        $link->method('__toString')->willReturn('test');
        $link->method('getKey')->willReturn('test');

        $deprecated = Deprecated::new()
            ->addLink($link);

        $deprecated->apply($response);

        $this->assertTrue($response->headers->has(Deprecated::HEADER));
        $this->assertEquals('true', $response->headers->get(Deprecated::HEADER));

        $this->assertTrue($response->headers->has('Link'));
        $this->assertEquals('test', $response->headers->get('Link'));
    }

    /** @test */
    public function it_applies_multiple_links_in_comma_separated_string()
    {
        $response = new Response();
        $link1 = $this->createMock(Link::class);
        $link1->method('__toString')->willReturn('test');
        $link1->method('getKey')->willReturn('test');

        $link2 = $this->createMock(Link::class);
        $link2->method('__toString')->willReturn('test2');
        $link2->method('getKey')->willReturn('test2');

        $deprecated = Deprecated::new()
            ->addLink($link1)
            ->addLink($link2);

        $deprecated->apply($response);

        $this->assertTrue($response->headers->has(Deprecated::HEADER));
        $this->assertEquals('true', $response->headers->get(Deprecated::HEADER));

        $this->assertTrue($response->headers->has('Link'));
        $this->assertEquals('test, test2', $response->headers->get('Link'));
    }
}
