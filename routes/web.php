<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('orgs.index');
});

Route::get('/orgs', function () {
    return view('orgs.index');
})->name('orgs.index');

Route::get('/orgs/create', function () {
    return view('orgs.index');
})->name('orgs.create');

Route::get('/orgs/archived', function () {
    return view('orgs.index');
})->name('orgs.archived');