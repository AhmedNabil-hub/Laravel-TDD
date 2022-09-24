<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BookController extends Controller
{
	public function store(Request $request): RedirectResponse
	{
		$validated_data = $request->validate(
			[
				'title' => 'required|string',
				'author' => 'required|string',
			],
		);

		$book = Book::create($validated_data);

		return redirect($book->path());
	}

	public function update(Request $request, Book $book): RedirectResponse
	{
		$validated_data = $request->validate(
			[
				'title' => 'required|string',
				'author' => 'required|string',
			],
		);

		$book->update($validated_data);

		return redirect($book->path());
	}

	public function destroy(Book $book): RedirectResponse
	{
		$book->delete();

		return redirect('/books');
	}
}
