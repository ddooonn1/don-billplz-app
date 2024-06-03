<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\GeneratorController;
use App\Http\Controllers\PizzaController;

Route::get('/', function () {
    return view('home');
});

Route::get('/password-generator', [GeneratorController::class, 'index'])->name('password.generator');

Route::post('/generate-password', [GeneratorController::class, 'generatePassword'])->name('generate.password');

Route::get('/pizza-parlour', [PizzaController::class, 'index'])->name('pizza.home');

Route::post('/order-pizza', [PizzaController::class, 'calculateBill'])->name('order.pizza');