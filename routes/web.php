<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;

Route::get('/', function () {
	return view('welcome');
});

Route::resource('books', BookController::class)
	->except(['create', 'edit']);
Route::resource('authors', AuthorController::class)
	->except(['create', 'edit']);
