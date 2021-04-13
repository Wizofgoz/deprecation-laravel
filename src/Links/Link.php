<?php

declare(strict_types=1);

namespace Wizofgoz\DeprecationLaravel\Links;

use Stringable;

abstract class Link implements Stringable
{
    public const HEADER = 'Link';
    protected const REL = '';

    public function __construct(private string $uri)
    {
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return md5($this->__toString());
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * @param string $uri
     */
    public function setUri(string $uri): void
    {
        $this->uri = $uri;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return sprintf('<%s>; rel="%s"', $this->getUri(), static::REL);
    }
}
