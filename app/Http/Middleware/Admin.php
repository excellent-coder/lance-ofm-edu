<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Admin
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
        if (!Auth::check()) {
            session('next_url', url()->current());
            return redirect(route('login', 'login'));
        }
        if (Auth::user()->admin !== 1) {
            return redirect(route('home'));
        }

        return $next($request);
    }
}
