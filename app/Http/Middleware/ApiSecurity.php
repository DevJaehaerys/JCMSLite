<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiSecurity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $apiKey = config('app.api_key');
        $clientIp = $request->getClientIp();
        $allowedIps = config('app.allowed_ips');
        if ($apiKey && $request->header('X-API-KEY') !== $apiKey) {
            return response()->json(['error' => 'Invalid API key'], 401);
        }
        if ($allowedIps && !in_array($clientIp, $allowedIps)) {
            return response()->json(['error' => 'IP not allowed'], 403);
        }
        return $next($request);
    }
}
