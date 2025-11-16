<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Request as RequestAlias;
use Symfony\Component\HttpFoundation\Response;
use App\Services\EventLogger;

class LogPostRequests
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($request->isMethod(RequestAlias::METHOD_POST)) {
            EventLogger::log(
                $request->method() . ' ' . 'log',
                'Automatic POST log',
                $request->all()
            );
        }

        return $response;
    }
}
