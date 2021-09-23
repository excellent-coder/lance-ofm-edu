<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ActiveSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->id() || auth()->user()->ceo !== 1) {
            if (!in_array($request->path(), ['503', 'comming-soon'])) {
                if (!config('msc.session')) {
                    return redirect()->route('503');
                }
            }
        }
        return $next($request);
    }
}
