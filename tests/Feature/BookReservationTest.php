<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookReservationTest extends TestCase
{
	use RefreshDatabase;

	public function test_add_book()
	{
		$response = $this->post('/books', [
			'title' => 'Cool Book Title',
			'author' => 'Victor',
		]);

		$response->assertOk();
		$this->assertCount(1, Book::all());
	}

	public function test_title_is_required()
	{
		$response = $this->post('/books', [
			'title' => '',
			'author' => 'Victor',
		]);

		$response->assertSessionHasErrors('title');
	}

	public function test_author_is_required()
	{
		$response = $this->post('/books', [
			'title' => 'Cool Book Title',
			'author' => '',
		]);

		$response->assertSessionHasErrors('author');
	}

	public function test_update_book()
	{
		$this->post('/books', [
			'title' => 'Cool Book Title',
			'author' => 'Victor',
		]);

		$book = Book::latest()->first();

		$this->put('/books/' . $book->id, [
			'title' => 'New Cool Book Title',
			'author' => 'New Victor',
		]);

		$this->assertEquals('New Cool Book Title', Book::first()?->title);
		$this->assertEquals('New Victor', Book::first()?->author);
	}
}
