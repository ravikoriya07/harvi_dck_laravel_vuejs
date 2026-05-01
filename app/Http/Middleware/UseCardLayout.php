<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UseCardLayout
{
    public function handle(Request $request, Closure $next)
    {
        Inertia::setRootView('card');

        return $next($request);
    }
}
