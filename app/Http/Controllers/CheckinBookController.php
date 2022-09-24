<?php

namespace App\Http\Controllers;

use App\Models\Book;

class CheckinBookController extends Controller
{
	public function store(Book $book)
	{
		$user = auth()->user() ?? null;

		if (is_null($user)) {
			return redirect('/login');
		}

		try {
			$book->checkin(auth()->user());
		} catch (\Exception $e) {
			return response()->view('errors.404', [], 404);
		}
	}
}
