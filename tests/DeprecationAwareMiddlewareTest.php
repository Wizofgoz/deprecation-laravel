<?php

declare(strict_types=1);

namespace Wizofgoz\DeprecationLaravel\Tests;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Wizofgoz\DeprecationLaravel\Deprecated;
use Wizofgoz\DeprecationLaravel\Http\Middleware\DeprecationAwareMiddleware;
use Wizofgoz\DeprecationLaravel\Links\AlternateLink;
use Wizofgoz\DeprecationLaravel\Links\Link;
use Wizofgoz\DeprecationLaravel\Sunsetted;

class DeprecationAwareMiddlewareTest extends TestCase
{
    public function createMiddleware(): DeprecationAwareMiddleware
    {
        return new DeprecationAwareMiddleware($this->getService());
    }

    /** @test */
    public function it_doesnt_attach_headers_when_nothing_is_set()
    {
        $middleware = $this->createMiddleware();

        /** @var Response $response */
        $response = $middleware->handle(new Request(), fn () => new Response());

        $this->assertFalse($response->headers->has(Deprecated::HEADER));
        $this->assertFalse($response->headers->has(Link::HEADER));
        $this->assertFalse($response->headers->has(Sunsetted::HEADER));
    }

    /** @test */
    public function it_attaches_deprecated_header()
    {
        $middleware = $this->createMiddleware();
        $this->getService()->deprecate(Deprecated::new());

        /** @var Response $response */
        $response = $middleware->handle(new Request(), fn () => new Response());

        $this->assertTrue($response->headers->has(Deprecated::HEADER));
        $this->assertFalse($response->headers->has(Link::HEADER));
        $this->assertFalse($response->headers->has(Sunsetted::HEADER));
    }

    /** @test */
    public function it_attaches_deprecated_and_link_headers()
    {
        $middleware = $this->createMiddleware();
        $this->getService()->deprecate(Deprecated::new()->addLink(new AlternateLink('https://example.com/test')));

        /** @var Response $response */
        $response = $middleware->handle(new Request(), fn () => new Response());

        $this->assertTrue($response->headers->has(Deprecated::HEADER));
        $this->assertTrue($response->headers->has(Link::HEADER));
        $this->assertFalse($response->headers->has(Sunsetted::HEADER));
    }

    /** @test */
    public function it_attaches_sunsetted_header()
    {
        $middleware = $this->createMiddleware();
        $this->getService()->sunset(Sunsetted::new(Carbon::now()));

        /** @var Response $response */
        $response = $middleware->handle(new Request(), fn () => new Response());

        $this->assertFalse($response->headers->has(Deprecated::HEADER));
        $this->assertFalse($response->headers->has(Link::HEADER));
        $this->assertTrue($response->headers->has(Sunsetted::HEADER));
    }

    /** @test */
    public function it_doesnt_attach_headers_when_unset()
    {
        $middleware = $this->createMiddleware();
        $this->getService()->deprecate(Deprecated::new());
        $this->getService()->sunset(Sunsetted::new(Carbon::now()));
        $this->getService()->deprecate(null);
        $this->getService()->sunset(null);

        /** @var Response $response */
        $response = $middleware->handle(new Request(), fn () => new Response());

        $this->assertFalse($response->headers->has(Deprecated::HEADER));
        $this->assertFalse($response->headers->has(Link::HEADER));
        $this->assertFalse($response->headers->has(Sunsetted::HEADER));
    }
}
