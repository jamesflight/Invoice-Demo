<?php
namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Support\Facades\Log;

class CliErrorHandler
{
    public function handle($request, Closure $next)
    {
        return $next($request);
    }

    public function terminate($request, $response)
    {
        if (property_exists($response, 'exception')) {
            throw $response->exception;
        }
    }
}
