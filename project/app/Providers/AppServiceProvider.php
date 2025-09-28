<?php

namespace App\Providers;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\AuthenticationException;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */

    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            //only 60 requests per minute from one ip
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip())->response(
                function (Request $request, array $headers) {
                    return response()->json([
                        'message' => 'Too many requests.'
                    ], 429);
                }
                );
        });
        Route::pattern('id', '[0-9]+');
        Route::pattern('product', '[0-9]+');

        Gate::define('admin-action', function (User $user) {
            return $user->is_admin;
        });
        Gate::define('cart-delete', function (User $user, Cart $cart) {
            return $user->id === $cart->user_id;
        });
    }
}
