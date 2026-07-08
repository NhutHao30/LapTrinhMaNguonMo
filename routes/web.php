<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Lab2Controller;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('lab2')->group(function () {
    Route::get('/', [Lab2Controller::class, 'index'])->name('lab2.index');
    Route::get('/bt1', [Lab2Controller::class, 'bt1'])->name('lab2.bt1');
    Route::get('/bt2', [Lab2Controller::class, 'bt2'])->name('lab2.bt2');
    Route::get('/bt3', [Lab2Controller::class, 'bt3'])->name('lab2.bt3');
    Route::get('/bt4', [Lab2Controller::class, 'bt4'])->name('lab2.bt4');
    Route::get('/bt5', [Lab2Controller::class, 'bt5'])->name('lab2.bt5');
    Route::get('/bt6', [Lab2Controller::class, 'bt6'])->name('lab2.bt6');
    Route::get('/bt7', [Lab2Controller::class, 'bt7'])->name('lab2.bt7');
    Route::get('/bt8', [Lab2Controller::class, 'bt8'])->name('lab2.bt8');
});
