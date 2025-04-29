<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class OwnerCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard('admin')->check()) {
            return redirect('/Adminlogin'); // Redirect to login if not authenticated
        }

        $admin = Auth::guard('admin')->user();

        // Check if the authenticated admin's status is 'Active'
        $admin = Auth::guard('admin')->user();

        // Check if the authenticated admin's status is 'Active'
        if ($admin->status != 'Owner') {
            Auth::guard('admin')->logout();
            return redirect('/Adminlogin')->back()->with('danger', 'Your account is not active.'); // Redirect to login with a message
        }

        return $next($request);
    }
}
