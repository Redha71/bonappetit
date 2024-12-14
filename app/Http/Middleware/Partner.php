<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class Partner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard('partner')->check()) {
            $notifiaction = array(
                'message'=> 'You do not have promission',
                'alert-type'=> 'error'
              );
            return redirect()->route('partner.login')->with($notifiaction);
         }
        return $next($request);
    }
}
