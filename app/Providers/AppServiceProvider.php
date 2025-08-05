<?php

namespace App\Providers;

use App\Models\Customer;
use App\Models\Product;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

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
        //
        DB::listen(function (QueryExecuted $query) {
            // Log the executed query
            \Log::info('Query Executed: ' . $query->sql, $query->bindings);
        });

        Relation::enforceMorphMap([
            'product' => Product::class,
            'customer' => Customer::class
        ]);
    }
}
