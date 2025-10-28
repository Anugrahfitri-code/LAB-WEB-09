<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;


Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('/destinasi', [HomeController::class, 'destinasi'])->name('destinasi');
Route::get('/kuliner', [HomeController::class, 'kuliner'])->name('kuliner');
Route::get('/galeri', [HomeController::class, 'galeri'])->name('galeri');
Route::get('/kontak', [HomeController::class, 'kontak'])->name('kontak');
Route::get('/agenda', [HomeController::class, 'agenda'])->name('agenda'); 