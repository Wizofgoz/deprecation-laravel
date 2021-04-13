<?php

namespace Wizofgoz\DeprecationLaravel\Facades;

use Illuminate\Support\Facades\Facade;
use Wizofgoz\DeprecationLaravel\Deprecated;
use Wizofgoz\DeprecationLaravel\DeprecationService;
use Wizofgoz\DeprecationLaravel\Sunsetted;

/**
 * @see \Wizofgoz\DeprecationLaravel\DeprecationService
 *
 * @method static void deprecate(?Deprecated $deprecated)
 * @method static Deprecated|null getDeprecated()
 * @method static bool isDeprecationBound()
 * @method static bool isDeprecated()
 * @method static void sunset(?Sunsetted $sunset)
 * @method static Sunsetted|null getSunsetted()
 * @method static bool isSunsetBound()
 * @method static bool isSunsetted()
 */
class Deprecation extends Facade
{
    protected static function getFacadeAccessor()
    {
        return DeprecationService::class;
    }
}
