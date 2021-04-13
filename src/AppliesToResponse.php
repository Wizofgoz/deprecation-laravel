<?php

declare(strict_types=1);

namespace Wizofgoz\DeprecationLaravel;

use Illuminate\Http\Response;

interface AppliesToResponse
{
    /**
     * Apply the object to the given response.
     * @param Response $response
     */
    public function apply(Response $response): void;
}
