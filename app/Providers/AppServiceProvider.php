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
     * Path ke "home" route untuk aplikasi Anda.
     * Ini biasanya digunakan oleh middleware 'guest' untuk redirect jika sudah login.
     *
     * @var string
     */
    // 1. UBAH INI ke fallback admin dashboard Anda
    public const HOME = '/admin/dashboard';

    /**
     * 2. TAMBAHKAN DUA KONSTANTA INI
     * Ini adalah path khusus untuk role-based redirect di LoginController kita.
     */
    public const HOME_ADMIN = '/admin/dashboard';
    public const HOME_BERITA = '/admin/berita'; // Sesuaikan jika rute admin berita Anda berbeda

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}