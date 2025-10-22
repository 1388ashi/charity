<?php


namespace Modules\Sms;

use App\Providers\AppServiceProvider;
use Illuminate\Support\ServiceProvider;
use Modules\Sms\SmsService;

class SmsServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('sms',function () {
            return new SmsService();
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/sms.php' => config_path('sms.php')
        ]);
        if (!AppServiceProvider::$configurationIsCached || AppServiceProvider::$runningInConsole) {
            $this->mergeConfigFrom(__DIR__ . '/config/sms.php', 'sms');
        }
    }

}
