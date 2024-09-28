<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //dd($request); デバッグ方法 adminかどうかを判別できてるか確認したい時は()内にauth()->user()->roleを入れたりする
        if(auth()->user()->role == 'admin') {
        return $next($request);
        }
        return redirect()->route('dashboard');
    }
}
