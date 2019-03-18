<?php

namespace App\Http\Middleware;

use Closure;

class IsOrganizer
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
        if (auth()->user()->role == \App\User::USER_ROLE_ORGANIZER) {
            return $next($request);
        }

        return redirect('/'); // If user is not an admin.
    }
}
