<?php

use App\Http\Controllers\LeadController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    Route::post('leads/data', [LeadController::class, 'data'])->name('leads.data');
    Route::get('leads-export', [LeadController::class, 'export'])->name('leads.export');
    Route::resource('leads', LeadController::class);
});

require __DIR__.'/auth.php';
