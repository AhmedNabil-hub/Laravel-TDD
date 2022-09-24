<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class AuthorController extends Controller
{
	public function store(Request $request): RedirectResponse
	{
		$validated_data = $request->validate(
			[
				'name' => 'required|string',
				'dob' => 'required|string',
			]
		);

		$author = Author::create($validated_data);

		return redirect($author->path());
	}

	public function update(Request $request, Author $author): RedirectResponse
	{
		$validated_data = $request->validate(
			[
				'name' => 'required|string',
				'dob' => 'required|string',
			]
		);

		$author->update($validated_data);

		return redirect($author->path());
	}

	public function destroy(Author $author): RedirectResponse
	{
		$author->delete();

		return redirect('/authors');
	}
}
