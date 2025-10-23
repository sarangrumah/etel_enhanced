<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Helpers\LogHelper;

class LogActivity
{
    protected $logHelper;

    public function __construct(LogHelper $logHelper)
    {
        $this->logHelper = $logHelper;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if (in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE'])) {
            $this->logHelper->createLog(
                $request->route()->getActionMethod(),
                'User action detected via middleware.',
                $request->except(['password', 'password_confirmation']),
                null,
                'This log was generated automatically by middleware.'
            );
        }

        return $response;
    }
}
