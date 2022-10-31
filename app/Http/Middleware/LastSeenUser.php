<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Auth;
use Carbon\Carbon;

use Illuminate\Http\Request;

class LastSeenUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {           
            User::where('id', Auth::user()->id)->update(['ultima_vez' => Carbon::now()]);
        }
        return $next($request);
    }
}
