<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Remove X-Powered-By header (information disclosure)
        $response->headers->remove('X-Powered-By');

        // Strict-Transport-Security: Enforce HTTPS
        $response->header('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');

        // X-Content-Type-Options: Prevent MIME type sniffing
        $response->header('X-Content-Type-Options', 'nosniff');

        // X-Frame-Options: Prevent clickjacking
        $response->header('X-Frame-Options', 'SAMEORIGIN');

        // X-XSS-Protection: Enable XSS filter
        $response->header('X-XSS-Protection', '1; mode=block');

        // Content-Security-Policy: Prevent XSS, injection attacks
        $response->header(
            'Content-Security-Policy',
            "default-src 'self'; " .
            "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.jsdelivr.net https://code.jquery.com https://cdn.datatables.net https://accounts.google.com; " .
            "style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://cdn.datatables.net https://cdnjs.cloudflare.com https://fonts.googleapis.com; " .
            "img-src 'self' data: https: blob:; " .
            "font-src 'self' https://cdnjs.cloudflare.com https://fonts.gstatic.com; " .
            "connect-src 'self' https://accounts.google.com https://apis.google.com; " .
            "frame-src https://accounts.google.com; " .
            "frame-ancestors 'self'; " .
            "base-uri 'self'; " .
            "form-action 'self' https://accounts.google.com;"
        );

        // Referrer-Policy: Control referrer information
        $response->header('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Permissions-Policy: Control browser features
        $response->header(
            'Permissions-Policy',
            'geolocation=(), microphone=(), camera=(), payment=(), usb=(), magnetometer=(), gyroscope=(), accelerometer=()'
        );

        // Remove server identification
        $response->header('Server', '');

        // Additional security headers
        $response->header('X-Permitted-Cross-Domain-Policies', 'none');
        $response->header('X-UA-Compatible', 'IE=edge');

        return $response;
    }
}