<?php

declare(strict_types=1);

namespace Wizofgoz\DeprecationLaravel\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Wizofgoz\DeprecationLaravel\Links\Link;
use Wizofgoz\DeprecationLaravel\Links\LinkCollection;

class LinkCollectionTest extends TestCase
{
    /** @test */
    public function it_adds_links()
    {
        $collection = new LinkCollection();
        $link = $this->createMock(Link::class);
        $link->method('getKey')->willReturn('test');

        $collection->addLink($link);

        $this->assertEquals($link, $collection->offsetGet('test'));
        $this->assertFalse($collection->empty());
        $this->assertTrue($collection->notEmpty());
    }

    /** @test */
    public function it_is_empty_when_instantiated()
    {
        $collection = new LinkCollection();

        $this->assertTrue($collection->empty());
    }

    /** @test */
    public function it_adds_like_array()
    {
        $collection = new LinkCollection();
        $link = $this->createMock(Link::class);
        $link->method('getKey')->willReturn('test');

        $collection[$link->getKey()] = $link;

        $this->assertEquals($link, $collection->offsetGet('test'));
        $this->assertFalse($collection->empty());
    }

    /** @test */
    public function it_unsets_like_array()
    {
        $collection = new LinkCollection();
        $link = $this->createMock(Link::class);
        $link->method('getKey')->willReturn('test');

        $collection->addLink($link);
        unset($collection[$link->getKey()]);

        $this->assertTrue($collection->empty());
    }

    /** @test */
    public function it_checks_like_array_for_isset()
    {
        $collection = new LinkCollection();
        $link = $this->createMock(Link::class);
        $link->method('getKey')->willReturn('test');

        $collection->addLink($link);

        $this->assertTrue(isset($collection['test']));
        $this->assertFalse(isset($collection['test2']));
    }

    /** @test */
    public function it_implodes()
    {
        $collection = new LinkCollection();
        $link = $this->createMock(Link::class);
        $link->method('getKey')->willReturn('test');
        $link->method('__toString')->willReturn('value');
        $link2 = $this->createMock(Link::class);
        $link2->method('getKey')->willReturn('test2');
        $link2->method('__toString')->willReturn('value2');

        $collection->addLink($link)->addLink($link2);

        $this->assertEquals('value, value2', $collection->implode(', '));
    }
}
