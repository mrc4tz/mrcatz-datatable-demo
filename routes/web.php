<?php

use App\Livewire\Product\ProductPage;
use Illuminate\Support\Facades\Route;

Route::get('/', ProductPage::class);

// Temporary: run migrate & seed via browser — HAPUS SETELAH SELESAI
Route::get('/setup-db', function () {
    \Illuminate\Support\Facades\Artisan::call('migrate:fresh', ['--seed' => true, '--force' => true]);
    return 'Database migrated and seeded! <br><a href="/">Go to app</a><br><br><b>HAPUS ROUTE INI SETELAH SELESAI!</b>';
});
