<?php

use App\Http\Controllers\OrgController;
use Illuminate\Support\Facades\Route;

Route::get('/', [OrgController::class, 'index'])->name('orgs.index');
Route::post('/orgs', [OrgController::class, 'store'])->name('orgs.store');
Route::get('/orgs/archived', [OrgController::class, 'archived'])->name('orgs.archived');
Route::put('/orgs/{id}/restore', [OrgController::class, 'restore'])->name('orgs.restore');
Route::get('/orgs/{id}', [OrgController::class, 'show'])->name('orgs.show');
Route::put('/orgs/{id}/archive', [OrgController::class, 'archive'])->name('orgs.archive');
Route::get('/orgs/{id}/edit', [OrgController::class, 'edit'])->name('orgs.edit');
Route::delete('/orgs/{id}', [OrgController::class, 'destroy'])->name('orgs.destroy');
Route::get('/orgs/archived/{id}', [OrgController::class, 'archivedShow'])->name('orgs.archived.show');
Route::put('/orgs/{id}', [OrgController::class, 'update'])->name('orgs.update');
