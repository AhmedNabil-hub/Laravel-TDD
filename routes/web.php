<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CheckinBookController;
use App\Http\Controllers\CheckoutBookController;

Route::get('/', function () {
	return view('welcome');
});

Route::resource('books', BookController::class)
	->except(['create', 'edit']);
Route::resource('authors', AuthorController::class)
	->except(['create', 'edit']);

Route::post('/checkout/{book}', [CheckoutBookController::class, 'store']);
Route::post('/checkin/{book}', [CheckinBookController::class, 'store']);
