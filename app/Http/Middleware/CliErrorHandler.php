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
        if ($response->getStatusCode() === 500 || $response->getStatusCode() === 404) {
            throw $response->exception;
        }
    }
}
 