<?php

declare(strict_types=1);

namespace Wizofgoz\DeprecationLaravel\Http\Middleware;

use Closure;
use Illuminate\Http\Response;
use Wizofgoz\DeprecationLaravel\DeprecationService;

class DeprecationAwareMiddleware
{
    public function __construct(private DeprecationService $deprecationService)
    {
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        $this->applyDeprecated($response);
        $this->applySunset($response);

        return $response;
    }

    protected function applyDeprecated(Response $response): void
    {
        if ($deprecated = $this->deprecationService->getDeprecated()) {
            $deprecated->apply($response);
        }
    }

    protected function applySunset(Response $response): void
    {
        if ($sunsetted = $this->deprecationService->getSunsetted()) {
            $sunsetted->apply($response);
        }
    }
}
