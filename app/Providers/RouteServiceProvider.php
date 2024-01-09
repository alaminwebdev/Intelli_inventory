<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    // public const ADMIN_DASHBOARD = 'admin/dashboard';
    // public const MEMBER_DASHBOARD = 'member/dashboard';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    // protected $namespace = 'App\\Http\\Controllers';
    protected $nameSpaceAdmin = 'App\\Http\\Controllers\\Admin';
    protected $nameSpaceMember = 'App\\Http\\Controllers\\Member';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));

            Route::middleware(['web','revalidate'])
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));

            Route::middleware(['web', 'auth:admin','permission','revalidate'])
            ->name( 'admin.')
            ->prefix('admin')
            ->namespace($this->nameSpaceAdmin)
            ->group(base_path('routes/admin.php'));

            Route::middleware(['web', 'auth:member','revalidate'])
            ->name( 'member.')
            ->prefix('member')
            ->namespace($this->nameSpaceMember)
            ->group(base_path('routes/member.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
