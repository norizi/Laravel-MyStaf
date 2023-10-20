<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
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
        $user = \App\User::where('email', $request->email)->first();
        if ($user->id_role == '1') {
            return redirect('home');
        } else {
            return redirect('/');
        }

        return $next($request);
        //return $next($request);
    }
}
