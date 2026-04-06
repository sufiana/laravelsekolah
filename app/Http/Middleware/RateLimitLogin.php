<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\BruteForceProtectionService;

class RateLimitLogin
{
    protected $bruteForceService;

    public function __construct(BruteForceProtectionService $bruteForceService)
    {
        $this->bruteForceService = $bruteForceService;
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
        // Only apply to login route
        if ($request->getMethod() !== 'POST' || !$request->is('login')) {
            return $next($request);
        }

        $ipAddress = $this->bruteForceService->getClientIp();

        // Check if IP has too many attempts
        if ($this->bruteForceService->isTooManyAttemptsFromIp($ipAddress)) {
            return response()->json([
                'success' => false,
                'message' => 'Terlalu banyak percobaan login dari IP Anda. Silakan coba lagi dalam beberapa menit.',
                'error' => 'rate_limit_exceeded'
            ], 429);
        }

        return $next($request);
    }
}
