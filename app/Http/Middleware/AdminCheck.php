<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the admin is authenticated
        if (!Auth::guard('admin')->check()) {
            return redirect('/Adminlogin'); // Redirect to login if not authenticated
        }

        $admin = Auth::guard('admin')->user();

        // Check if the authenticated admin's status is 'Owner'
        if ($admin->status != 'Admin') {
            Auth::guard('admin')->logout(); // Log out the admin
            return redirect('/Adminlogin')->with('danger', 'Your account is not active.'); // Redirect to login with a message
        }

        return $next($request);
    }
}
