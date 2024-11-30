<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // This will log all queries, including Eloquent queries
        DB::listen(function ($query) {
            \Log::info("Query executed: " . $query->sql);
            \Log::info("Bindings: " . implode(', ', $query->bindings));
            \Log::info("Time: " . $query->time . "ms");
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
