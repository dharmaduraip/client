<?php

use Illuminate\Support\Facades\Route;

// ====================Artisan command======================
Route::middleware('auth:admin')->group(function () {
  
    Route::get('optimize', function () {
        \Artisan::call('optimize');
        dd("Optimized");
    });

    Route::get('optimize-clear', function () {
        \Artisan::call('optimize:clear');

        flashSuccess('Cache cleared successfully');
        return back();
    })->name('app.optimize-clear');

    Route::get('migrate-seed', function () {
        setEnv('APP_MODE', 'maintenance');
        \Artisan::call('migrate:fresh --seed');
        setEnv('APP_MODE', 'live');

        flashSuccess('Migrate Seed successfully');
        return back();
    })->name('app.migrate-seed');

    Route::get('view-clear', function () {
        \Artisan::call('view:clear');
        dd("View Cleared");
    });

    Route::get('view-cache', function () {
        \Artisan::call('view:cache');
        dd("View cleared and cached again");
    });

    Route::get('config-cache', function () {
        \Artisan::call('config:cache');
        dd("configuration cleared and cached again");
    });

    Route::get('config-clear', function () {
        \Artisan::call('config:clear');
        dd("configuration cleared again");
    });

    Route::get('storage-link', function () {
        \Artisan::call('storage:link');
        dd("storage link created");
    });
});

Route::get('routes', function() {
     \Artisan::call('route:list');
     return \Artisan::output();
});
Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
	// Artisan::call('config:cache');
	Artisan::call('view:clear');
	Artisan::call('route:clear');
    return "Your all Cache is cleared";
});
Route::get('migrate/data', function () {
    \Artisan::call("migrate");

    dd("Migrated data");
});
