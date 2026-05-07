<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $routeMiddleware = [
        // ... other middleware
        'role' => \App\Http\Middleware\RoleMiddleware::class,
         'super.admin' => \App\Http\Middleware\SuperAdminMiddleware::class,
'approved' => \App\Http\Middleware\CheckApproved::class,
'subscription' => \App\Http\Middleware\CheckSubscription::class,
    ];
}