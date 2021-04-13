<?php

declare(strict_types=1);

namespace Wizofgoz\DeprecationLaravel\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Wizofgoz\DeprecationLaravel\Links\SuccessorLink;

class SuccessorLinkTest extends TestCase
{
    /** @test */
    public function it_updates_its_uri()
    {
        $link = new SuccessorLink('https://example.com/test');
        $newUri = 'https://example.com/test2';

        $link->setUri($newUri);

        $this->assertEquals($newUri, $link->getUri());
    }

    /** @test */
    public function it_converts_to_string()
    {
        $link = new SuccessorLink('https://example.com/test');

        $this->assertEquals('<https://example.com/test>; rel="successor-version"', (string)$link);
    }
}
