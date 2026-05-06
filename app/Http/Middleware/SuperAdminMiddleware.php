<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SuperAdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // التحقق من وجود جلسة Super Admin
        if (!session()->has('super_admin_logged_in')) {
            return redirect()->route('admin.login.form');
        }

        return $next($request);
    }
}