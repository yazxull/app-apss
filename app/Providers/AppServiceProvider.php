<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();

        \Illuminate\Database\Eloquent\Relations\Relation::enforceMorphMap([
            'admin' => 'App\Models\Admin',
            'siswa' => 'App\Models\Siswa',
        ]);
    }
}
