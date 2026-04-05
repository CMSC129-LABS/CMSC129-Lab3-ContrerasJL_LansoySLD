<?php

use App\Http\Controllers\OrgController;
use Illuminate\Support\Facades\Route;

Route::get('/', [OrgController::class, 'index'])->name('orgs.index');
Route::get('/orgs/create', [OrgController::class, 'create'])->name('orgs.create');
Route::post('/orgs', [OrgController::class, 'store'])->name('orgs.store');
Route::get('/orgs/archived', [OrgController::class, 'archived'])->name('orgs.archived');
Route::put('/orgs/{id}/restore', [OrgController::class, 'restore'])->name('orgs.restore');
