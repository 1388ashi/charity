<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;
class ScheduleServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot()
    {
        $this->app->booted(function () {
            $schedule = app(Schedule::class);
            // $schedule->job(new ProductChangeStatusJob)->everyMinute();
        });
    }
}
