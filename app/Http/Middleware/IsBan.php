<?php

namespace App\Http\Middleware;

use Closure;

class IsBan
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->check() && auth()->user()->is_ban) {
            auth()->logout();
            return redirect()->route('login')->withMessage('Вы забанены');
        }
        return $next($request);
    }
}
