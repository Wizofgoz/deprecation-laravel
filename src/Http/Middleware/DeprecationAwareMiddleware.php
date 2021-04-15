<?php

declare(strict_types=1);

namespace Wizofgoz\DeprecationLaravel\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Wizofgoz\DeprecationLaravel\DeprecationService;
use Wizofgoz\DeprecationLaravel\Events\DeprecatedResourceCalled;
use Wizofgoz\DeprecationLaravel\Events\SunsettedResourceCalled;

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

        $this->applyDeprecated($response, $request);
        $this->applySunset($response, $request);

        return $response;
    }

    protected function applyDeprecated(Response $response, Request $request): void
    {
        if ($deprecated = $this->deprecationService->getDeprecated()) {
            $deprecated->apply($response);

            event(new DeprecatedResourceCalled($request, $deprecated));
        }
    }

    protected function applySunset(Response $response, Request $request): void
    {
        if ($sunsetted = $this->deprecationService->getSunsetted()) {
            $sunsetted->apply($response);

            event(new SunsettedResourceCalled($request, $sunsetted));
        }
    }
}
