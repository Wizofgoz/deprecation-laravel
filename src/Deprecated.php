<?php

declare(strict_types=1);

namespace Wizofgoz\DeprecationLaravel;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Wizofgoz\DeprecationLaravel\Links\Link;
use Wizofgoz\DeprecationLaravel\Links\LinkCollection;

final class Deprecated implements AppliesToResponse
{
    public const HEADER = 'Deprecated';

    protected function __construct(private LinkCollection $links, private ?Carbon $date)
    {
    }

    /**
     * @return static
     */
    public static function new(): self
    {
        return new self(new LinkCollection(), null);
    }

    /**
     * @return LinkCollection
     */
    public function getLinks(): LinkCollection
    {
        return $this->links;
    }

    /**
     * @return Carbon|null
     */
    public function getDate(): ?Carbon
    {
        return $this->date;
    }

    /**
     * @param Link $link
     * @return $this
     */
    public function addLink(Link $link): self
    {
        $this->links->addLink($link);

        return $this;
    }

    /**
     * @param Carbon|null $date
     * @return $this
     */
    public function setDate(?Carbon $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return bool
     */
    public function isActiveNow(): bool
    {
        if ($this->getDate() === null) {
            return true;
        }

        return $this->getDate()->isPast();
    }

    /**
     * @param Response $response
     */
    public function apply(Response $response): void
    {
        $response->header(self::HEADER, $this->getHeaderValue());

        if ($this->getLinks()->notEmpty()) {
            $response->header(Link::HEADER, $this->getLinks()->implode(', '));
        }
    }

    /**
     * @return string
     */
    protected function getHeaderValue(): string
    {
        if ($this->getDate() === null) {
            return 'true';
        }

        return $this->getDate()->toRfc7231String();
    }
}
