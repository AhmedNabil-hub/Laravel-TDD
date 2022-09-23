<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BookController extends Controller
{
	public function store(Request $request): Response
	{
		$validated_data = $request->validate(
			[
				'title' => 'required|string',
				'author' => 'required|string',
			],
		);

		Book::create($validated_data);

		return response(
			'success',
			Response::HTTP_OK
		);
	}

	public function update(Request $request, Book $book): Response
	{
		$validated_data = $request->validate(
			[
				'title' => 'required|string',
				'author' => 'required|string',
			],
		);

		$book->update($validated_data);

		return response(
			'success',
			Response::HTTP_OK
		);
	}
}
