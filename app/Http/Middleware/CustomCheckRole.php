<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redis;

class CustomCheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'error' => ['You must log in to view this page!'],
            ]);
        }
        $user = Auth::user();
        if (!$user || $user->role != 'admin') {
            return response()->json([
                'success' => false,
                'error' => ['You may not use this site!'],
               
            ]);
        }
        session(['isAdmin' => true]);
        // $this->mergeRecentlyViewedProducts();
        return $next($request);
    }
    protected function mergeRecentlyViewedProducts()
    {
        $userId = Auth::id();
        $sessionRecentlyViewedKey = Session::getId();
        $userRecentlyViewedKey = $userId;
        $sessionRecentlyViewed = Redis::lrange($sessionRecentlyViewedKey, 0, 120);
        $userRecentlyViewed = Redis::lrange($userRecentlyViewedKey, 0, 120);
        $mergedRecentlyViewed = array_unique(array_merge($sessionRecentlyViewed, $userRecentlyViewed));
        Redis::del($userRecentlyViewedKey);
        foreach (array_reverse($mergedRecentlyViewed) as $productId) {
            Redis::lpush($userRecentlyViewedKey, $productId);
        }
        Redis::expire($userRecentlyViewedKey, 15 * 24 * 60 * 60);
        Redis::del($sessionRecentlyViewedKey);
    }
}
