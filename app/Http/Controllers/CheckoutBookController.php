<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CheckoutBookController extends Controller
{
  public function store(Book $book)
	{
		$user = auth()->user() ?? null;

		if(is_null($user)) {
			return redirect('/login');
		}

		$book->checkout(auth()->user());
	}
}
