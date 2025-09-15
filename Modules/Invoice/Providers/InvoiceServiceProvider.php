<?php

namespace Modules\Invoice\Providers;

use App\Providers\AppServiceProvider;
use Illuminate\Support\ServiceProvider;
use Modules\Invoice\Classes\PayDriver;
//use Modules\Invoice\Events\GoingToVerifyPayment;
//use Modules\Invoice\Events\PaymentVerified;
//use Modules\Invoice\Listeners\CheckStoreOnVerified;

class InvoiceServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Invoice';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'invoice';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
//        $this->registerTranslations();

        if (!AppServiceProvider::$configurationIsCached || AppServiceProvider::$runningInConsole) {
            $this->registerConfig();
        }
//        $this->registerViews();
        if (AppServiceProvider::$runningInConsole) {
            $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));
        }
        $this->registerDrivers();
        $this->app['events']->listen(GoingToVerifyPayment::class , CheckStoreOnVerified::class);
    }

    public function registerDrivers()
    {
        $this->app->singleton(PayDriver::class, function () {
            $defaultDriver = $driverName = config('invoice.default_diver');
            $driver = config('invoice.drivers')[$defaultDriver];
            if (request('payment_driver') && isset(config('invoice.drivers')[request('payment_driver')])) {
                $driverName = request('payment_driver');
                $driver = config('invoice.drivers')[request('payment_driver')];
            } else if (request()->route('gateway') && isset(config('invoice.drivers')[request()->route('gateway')])) {
                $driver = config('invoice.drivers')[request()->route('gateway')];
            }

            return new $driver['model']($driver['options'], $driverName);
        });

        foreach (config('invoice.drivers') as $driverName => $driver) {
            $model = $driver['model'];
            $options = $driver['options'];
            $this->app->singleton($model, function () use ($model, $options, $driverName){
                return new $model($options, $driverName);
            });
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
//        if (!AppServiceProvider::$routesAreCached || AppServiceProvider::$runningInConsole) {
//            $this->app->register(RouteServiceProvider::class);
//        }
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            module_path($this->moduleName, 'config/config.php') => config_path($this->moduleNameLower . '.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path($this->moduleName, 'config/config.php'), $this->moduleNameLower
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/' . $this->moduleNameLower);

        $sourcePath = module_path($this->moduleName, 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ], ['views', $this->moduleNameLower . '-module-views']);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->moduleNameLower);
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/' . $this->moduleNameLower);

        if (is_dir($langPath)) {
            $this->loadJsonTranslationsFrom($langPath);
            $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
        } else {
            $this->loadJsonTranslationsFrom(module_path($this->moduleName, 'Resources/lang'));
            $this->loadTranslationsFrom(module_path($this->moduleName, 'Resources/lang'), $this->moduleNameLower);
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    private function getPublishableViewPaths(): array
    {
        $paths = [];
        foreach (\Config::get('view.paths') as $path) {
            if (is_dir($path . '/modules/' . $this->moduleNameLower)) {
                $paths[] = $path . '/modules/' . $this->moduleNameLower;
            }
        }
        return $paths;
    }
}
