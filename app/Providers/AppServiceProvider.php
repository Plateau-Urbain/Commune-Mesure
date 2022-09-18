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

        app('view');
        $blade = app('blade.compiler');

        $blade->directive('svg', function($arguments) {
            // Funky madness to accept multiple arguments into the directive
            list($path, $class) = array_pad(explode(',', trim($arguments, "() ")), 2, '');
            $path = trim($path, "' ");
            $class = trim($class, "' ");

            // Create the dom document as per the other answers
            $svg = new \DOMDocument();
            $svg->load(resource_path($path));
            $svg->documentElement->setAttribute("class", $class);
            $output = $svg->saveXML($svg->documentElement);

            return $output;
        });
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
