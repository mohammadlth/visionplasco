<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Mockery\Exception;
use Symfony\Component\HttpFoundation\Response;

class ExpireAccountCheck
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $route_name = $request->route()->getName();
        if ($route_name == 'portal.payment' || $request->path() == 'portal/plans' || $request->path() == 'portal/change/level/buyer' || $request->path() == 'portal/change/level/seller') {
            return $next($request);
        }

        $user = Auth::user();

        if (Auth::user()->account == 'buyer') {
            return $next($request);
        }


        $date_now = strtotime(Carbon::now()->startOfDay());

        if (!is_null($user->vip_expire_at)) {
            $date_expire = strtotime(Carbon::make($user->vip_expire_at)->endOfDay());
            $diff = $date_expire - $date_now;
        } else {
            $diff = -1;
        }


        if ($diff < 0) {
            return redirect()->route('portal.plan', ['expire' => true]);
        } else {
            return $next($request);
        }

    }
}
