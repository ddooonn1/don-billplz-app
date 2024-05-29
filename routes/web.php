<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\GeneratorController;

Route::get('/', function () {
    return view('home');
});

Route::post('/generate-password', [GeneratorController::class, 'generatePassword'])->name('generate.password');