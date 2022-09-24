<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Book;
use App\Models\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookCRUDTest extends TestCase
{
	use RefreshDatabase;

	public function test_add_book()
	{
		$response = $this->post('/books', [
			'title' => 'Cool Book Title',
			'author_id' => 'Victor',
		]);

		$book = Book::latest()->first();

		$this->assertCount(1, Book::all());
		$response->assertRedirect($book->path());
	}

	public function test_title_is_required()
	{
		$response = $this->post('/books', [
			'title' => '',
			'author_id' => 'Victor',
		]);

		$response->assertSessionHasErrors('title');
	}

	public function test_author_is_required()
	{
		$response = $this->post('/books', [
			'title' => 'Cool Book Title',
			'author_id' => '',
		]);

		$response->assertSessionHasErrors('author_id');
	}

	/** @test */
	public function test_add_author_automatically()
	{
		$this->post('/books', [
			'title' => 'Cool Title',
			'author_id' => 'Victor',
		]);

		$book = Book::latest()->first();
		$author = Author::latest()->first();

		$this->assertCount(1, Author::all());
		$this->assertEquals($author->id, $book->author_id);
	}


	public function test_update_book()
	{
		$this->post('/books', [
			'title' => 'Cool Book Title',
			'author_id' => 'Victor',
		]);

		$book = Book::latest()->first();
		$author = Author::latest()->first();

		$this->assertCount(1, Author::all());
		$this->assertEquals($author->id, $book->author_id);

		$response = $this->put($book->path(), [
			'title' => 'New Cool Book Title',
			'author_id' => 'New Victor',
		]);

		$author = Author::latest()->first();
		$this->assertEquals($author->id, $book->author_id);

		$this->assertEquals('New Cool Book Title', Book::first()?->title);

		$response->assertRedirect($book->fresh()->path());
	}

	public function test_delete_book()
	{
		$this->post('/books', [
			'title' => 'Cool Book Title',
			'author_id' => 'Victor',
		]);

		$book = Book::latest()->first();

		$response = $this->delete($book->path());

		$this->assertCount(0, Book::all());
		$response->assertRedirect('/books');
	}
}
