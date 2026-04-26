<?php

use App\Http\Controllers\OrgController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatbotController;

Route::get('/', [OrgController::class, 'index'])->name('orgs.index');
Route::post('/orgs', [OrgController::class, 'store'])->name('orgs.store');

// specific routes first
Route::get('/orgs/search', [OrgController::class, 'search'])->name('orgs.search');
Route::get('/orgs/archived', [OrgController::class, 'archived'])->name('orgs.archived');
Route::get('/orgs/archived/{id}', [OrgController::class, 'archivedShow'])->name('orgs.archived.show');

// wildcard routes last
Route::put('/orgs/{id}', [OrgController::class, 'update'])->name('orgs.update');
Route::delete('/orgs/{id}', [OrgController::class, 'destroy'])->name('orgs.destroy');
Route::put('/orgs/{id}/archive', [OrgController::class, 'archive'])->name('orgs.archive');
Route::put('/orgs/{id}/restore', [OrgController::class, 'restore'])->name('orgs.restore');
Route::get('/orgs/{id}', [OrgController::class, 'show'])->name('orgs.show');


Route::post('/chatbot/message', [ChatbotController::class, 'message'])
    ->name('chatbot.message')
    ->middleware('web');

Route::post('/chatbot/execute', [ChatbotController::class, 'executeCrud'])
    ->name('chatbot.execute')
    ->middleware('web');
