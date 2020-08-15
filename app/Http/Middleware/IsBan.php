<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;

class IsBan
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->check() && auth()->user()->is_ban) {
            if (auth()->user()->banned_until < new Carbon()) {
                $user = auth()->user();
                $user->is_ban = 0;
                $user->banned_until = null;
                $user->save();
            } else {
                auth()->logout();
                return redirect('/')->withErrors('Вы забанены');
            }

        }
        return $next($request);
    }
}
