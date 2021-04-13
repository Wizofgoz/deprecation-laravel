<?php

declare(strict_types=1);

namespace Wizofgoz\DeprecationLaravel;

use Carbon\Carbon;
use Illuminate\Http\Response;

final class Sunsetted implements AppliesToResponse
{
    public const HEADER = 'Sunset';

    protected function __construct(private Carbon $date)
    {
    }

    /**
     * @param Carbon $date
     * @return self
     */
    public static function new(Carbon $date): self
    {
        return new self($date);
    }

    /**
     * @return Carbon
     */
    public function getDate(): Carbon
    {
        return $this->date;
    }

    /**
     * @param Carbon $date
     * @return $this
     */
    public function setDate(Carbon $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @param Response $response
     */
    public function apply(Response $response): void
    {
        $response->header(self::HEADER, $this->date->toRfc7231String());
    }
}
