<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookTest extends TestCase
{
	use RefreshDatabase;

  /** @test */
  public function test_link_book_to_author()
  {
    Book::create([
      'title' => 'Cool Title',
			'author_id' => 'Victor',
    ]);

		$this->assertCount(1, Book::all());
  }
}
