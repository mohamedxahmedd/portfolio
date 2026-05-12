<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
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
        // utf8mb4 + InnoDB pre-5.7 index byte-limit safety. With VARCHAR(255)
        // and utf8mb4 (4 bytes/char) a single-column index would be 1020 bytes,
        // which exceeds the 767-byte limit on older MySQL versions. Capping
        // the default VARCHAR length at 191 keeps every index well under the
        // limit and is harmless on MySQL 5.7+, 8.0+, and MariaDB.
        Schema::defaultStringLength(191);
    }
}
