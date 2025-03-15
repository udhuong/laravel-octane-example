<?php

namespace App\Providers;

use Core\Domain\Repositories\UserRepository;
use Core\Infrastructure\Repositories\UserRepositoryImpl;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepository::class, UserRepositoryImpl::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            // Nghĩa là trong 1 phút, 1 user chỉ được phép gửi 60 request
            // Test thì thay 60 thành 1
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
