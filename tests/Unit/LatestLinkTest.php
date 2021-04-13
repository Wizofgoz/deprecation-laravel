<?php

declare(strict_types=1);

namespace Wizofgoz\DeprecationLaravel\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Wizofgoz\DeprecationLaravel\Links\LatestLink;

class LatestLinkTest extends TestCase
{
    /** @test */
    public function it_updates_its_uri()
    {
        $link = new LatestLink('https://example.com/test');
        $newUri = 'https://example.com/test2';

        $link->setUri($newUri);

        $this->assertEquals($newUri, $link->getUri());
    }

    /** @test */
    public function it_converts_to_string()
    {
        $link = new LatestLink('https://example.com/test');

        $this->assertEquals('<https://example.com/test>; rel="latest-version"', (string)$link);
    }
}
