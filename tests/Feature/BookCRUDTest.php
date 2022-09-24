<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookCRUDTest extends TestCase
{
	use RefreshDatabase;

	public function test_add_book()
	{
		$response = $this->post('/books', [
			'title' => 'Cool Book Title',
			'author' => 'Victor',
		]);

		$book = Book::latest()->first();

		$this->assertCount(1, Book::all());
		$response->assertRedirect($book->path());
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

		$response = $this->put($book->path(), [
			'title' => 'New Cool Book Title',
			'author' => 'New Victor',
		]);

		$this->assertEquals('New Cool Book Title', Book::first()?->title);
		$this->assertEquals('New Victor', Book::first()?->author);

		$response->assertRedirect($book->fresh()->path());
	}

	public function test_delete_book()
	{
		$this->post('/books', [
			'title' => 'Cool Book Title',
			'author' => 'Victor',
		]);

		$book = Book::latest()->first();

		$response = $this->delete($book->path());

		$this->assertCount(0, Book::all());
		$response->assertRedirect('/books');
	}
}
