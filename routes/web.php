<?php

use App\Http\Controllers\CitizenController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CitizenController::class, 'index']);

Route::get('citizens/export/excel', [CitizenController::class, 'exportExcel'])->name('citizens.export.excel');
Route::get('citizens/export/pdf', [CitizenController::class, 'exportPdf'])->name('citizens.export.pdf');

Route::resource('citizens', CitizenController::class)->except([
    'show',
]);
