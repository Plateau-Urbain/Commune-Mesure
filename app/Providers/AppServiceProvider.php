<?php

namespace App\Providers;

use App\Interfaces\ImpactSocialRepositoryInterface;
use App\Repositories\ImpactSocialRepository;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Carbon;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Carbon::setLocale(config('app.locale'));
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ImpactSocialRepositoryInterface::class, ImpactSocialRepository::class);
    }
}
