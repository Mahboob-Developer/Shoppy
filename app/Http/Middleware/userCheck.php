<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Import the Auth facade
use Symfony\Component\HttpFoundation\Response;

class userCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard('web')->check()) {
            return redirect()->back(); // Redirect to login if not authenticated
        }

        $admin = Auth::guard('web')->user();

        // Check if the authenticated admin's status is 'Active'
        if ($admin->status != 'Active') {
            Auth::guard('web')->logout(); // Log out the user
            return redirect('/login')->with('danger', 'Your account is not active.'); // Redirect to login with a message
        }
        return $next($request);
    }
}
