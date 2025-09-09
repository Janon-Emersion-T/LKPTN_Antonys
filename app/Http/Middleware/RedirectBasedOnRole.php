<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectBasedOnRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()) {
            $user = $request->user();
            
            // If accessing staff dashboard but user is customer
            if ($request->is('dashboard*') && $user->isCustomer()) {
                return redirect()->route('customer.dashboard');
            }
            
            // If accessing customer dashboard but user is staff
            if ($request->is('customer/*') && $user->isStaff()) {
                return redirect()->route('dashboard');
            }
        }

        return $next($request);
    }
}
