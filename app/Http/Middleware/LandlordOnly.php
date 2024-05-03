<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Mth\Landlord\Core\Services\TenancyService;
use Symfony\Component\HttpFoundation\Response;

class LandlordOnly
{
    public function __construct(
        private readonly TenancyService $tenancyService
    ) {

    }

    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next)
    {
        if ($this->tenancyService->checkCurrent()) {
            // Optionally, redirect to a different page or abort with a 403
            return abort(404);
        }

        return $next($request);
    }
}
