<?php

declare(strict_types=1);

namespace Wizofgoz\DeprecationLaravel\Links;

use ArrayAccess;

class LinkCollection implements ArrayAccess
{
    /**
     * @var Link[]
     */
    private array $links = [];

    /**
     * @param Link $link
     * @return $this
     */
    public function addLink(Link $link): self
    {
        $this->offsetSet($link->getKey(), $link);

        return $this;
    }

    /**
     * @return bool
     */
    public function empty(): bool
    {
        return empty($this->links);
    }

    /**
     * @return bool
     */
    public function notEmpty(): bool
    {
        return ! $this->empty();
    }

    /**
     * @param string $separator
     * @return string
     */
    public function implode(string $separator): string
    {
        return implode($separator, $this->links);
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset): bool
    {
        return isset($this->links[$offset]);
    }

    /**
     * @param mixed $offset
     * @return Link|null
     */
    public function offsetGet($offset): ?Link
    {
        return $this->links[$offset];
    }

    /**
     * @param mixed $offset
     * @param Link $value
     */
    public function offsetSet($offset, $value): void
    {
        $this->links[$offset] = $value;
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset): void
    {
        unset($this->links[$offset]);
    }
}
