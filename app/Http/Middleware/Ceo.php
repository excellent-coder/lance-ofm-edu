<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Ceo
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
            session(['admin.redirect' => url()->current()]);
            return redirect('/');
        }

        if (Auth::user()->ceo !== 1) {
            return redirect(route('home'));
        }
        return $next($request);
    }
}
