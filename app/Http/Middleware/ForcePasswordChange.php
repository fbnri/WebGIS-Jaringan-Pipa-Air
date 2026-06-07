<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForcePasswordChange
{
    public function handle(
        Request $request,
        Closure $next
    ): Response {
        if (
            auth()->check() &&
            auth()->user()->force_password_change
        ) {
            if (
                !$request->routeIs(
                    'password.force.change'
                ) &&
                !$request->routeIs(
                    'password.force.update'
                )
            ) {
                return redirect()->route(
                    'password.force.change'
                );
            }
        }

        return $next($request);
    }
}
