<?php

namespace App\Providers;

use App\Interfaces\ImpactSocialRepositoryInterface;
use App\Repositories\ImpactSocialRepository;
use App\Services\Manifest;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Carbon::setLocale(config('app.locale'));

        app('view');
        Blade::directive('manifest', function () {
            return "<?php echo (app('App\Services\Manifest'))->getSha() ?>";
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Manifest::class, function ($app) {
            $branch = (env('APP_ENV', 'local') === 'production')
                      ? 'prod'
                      : 'master';
            return new Manifest($branch);
        });
        $this->app->bind(ImpactSocialRepositoryInterface::class, ImpactSocialRepository::class);
    }
}
