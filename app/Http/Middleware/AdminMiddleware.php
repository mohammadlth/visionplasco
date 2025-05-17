<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Mockery\Exception;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (!Auth::check()) {
            abort(403);
        }

        if (!Auth::user()->is_admin) {
            abort(403);
        }

        $route_name = $request->route()->getName();

        if ($route_name == 'dashboard'){
            return $next($request);
        }


        $explode = explode('.', $route_name);

        $user_permission = Auth::user()->admin_permission;

        if (!is_null($user_permission)) {
            $user_permission = json_decode($user_permission);
        } else {
            $user_permission = [];
        }

        $permission = DB::table('permissions')->where('route', $explode[0])->first();


        if (is_null($permission) || !in_array($permission->id, $user_permission) || $route_name == 'dashboard') {
            abort(403);
        }

        return $next($request);
    }
}
