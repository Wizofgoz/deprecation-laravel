<?php

declare(strict_types=1);

namespace Wizofgoz\DeprecationLaravel\Events;

use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;
use Wizofgoz\DeprecationLaravel\Sunsetted;

class SunsettedResourceCalled
{
    use SerializesModels;

    public function __construct(public Request $request, public Sunsetted $sunset)
    {
    }
}
