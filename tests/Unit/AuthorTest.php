<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;


class AuthorTest extends TestCase
{
	use RefreshDatabase;

  /** @test */
	public function test_dob_is_nullable()
	{
		Author::firstOrCreate([
			'name' => 'Ahmed',
		]);

		$this->assertCount(1, Author::all());
	}
}
