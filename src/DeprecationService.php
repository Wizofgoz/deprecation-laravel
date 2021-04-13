<?php

namespace Wizofgoz\DeprecationLaravel;

use Illuminate\Contracts\Foundation\Application;

class DeprecationService
{
    public function __construct(private Application $app)
    {
    }

    /**
     * Set/unset whether the request has been deprecated.
     * @param Deprecated|null $deprecated
     */
    public function deprecate(?Deprecated $deprecated): void
    {
        $this->app->singleton(Deprecated::class, fn() => $deprecated);
    }

    /**
     * Get the bound value for whether the current request is marked as deprecated.
     * @return Deprecated|null
     */
    public function getDeprecated(): ?Deprecated
    {
        if ($this->isDeprecatedBound()) {
            return $this->app->get(Deprecated::class);
        }

        return null;
    }

    /**
     * Whether the current resource has been marked as deprecated and effective in the past.
     * @return bool
     */
    public function isDeprecated(): bool
    {
        if ($deprecated = $this->getDeprecated()) {
            return $deprecated->isActiveNow();
        }

        return false;
    }

    /**
     * Whether there is a Deprecated instance bound yet.
     * @return bool
     */
    public function isDeprecatedBound(): bool
    {
        return $this->app->bound(Deprecated::class);
    }

    /**
     * Sets/unsets whether the request has been sunset.
     * @param Sunsetted|null $sunset
     */
    public function sunset(?Sunsetted $sunset): void
    {
        $this->app->singleton(Sunsetted::class, fn() => $sunset);
    }

    /**
     * Get the bound value for whether the request has been sunsetted.
     * @return Sunsetted|null
     */
    public function getSunsetted(): ?Sunsetted
    {
        if ($this->isSunsetted()) {
            return $this->app->get(Sunsetted::class);
        }

        return null;
    }

    /**
     * Whether the current resource has been marked as sunsetted, regardless of if it's in the future or not.
     * @return bool
     */
    public function isSunsetted(): bool
    {
        return $this->isSunsetBound();
    }

    /**
     * Whether there is a Sunsetted instance bound yet.
     * @return bool
     */
    public function isSunsetBound(): bool
    {
        return $this->app->bound(Sunsetted::class);
    }
}
