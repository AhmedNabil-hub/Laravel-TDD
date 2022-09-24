<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthorCRUDTest extends TestCase
{
	use RefreshDatabase;

	public function test_add_author()
	{
		$response = $this->post('/authors', [
			'name' => 'Author Name',
			'dob' => '09/29/1999',
		]);

		$author = Author::latest()->first();

		$this->assertCount(1, Author::all());
		$this->assertInstanceOf(Carbon::class, $author->dob);
		$this->assertEquals('09/29/1999', $author->dob->format('m/d/Y'));
		$response->assertRedirect($author->path());
	}

	public function test_name_is_required()
	{
		$response = $this->post('/authors', [
			'name' => '',
			'dob' => '09/29/1999',
		]);

		$response->assertSessionHasErrors('name');
	}

	public function test_dob_is_required()
	{
		$response = $this->post('/authors', [
			'name' => 'Author Name',
			'dob' => '',
		]);

		$response->assertSessionHasErrors('dob');
	}

	public function test_update_author()
	{
		$this->post('/authors', [
			'name' => 'Author Name',
			'dob' => '09/29/1999',
		]);

		$author = Author::latest()->first();

		$response = $this->put($author->path(), [
			'name' => 'New Author Name',
			'dob' => '10/04/1999',
		]);

		$this->assertEquals('New Author Name', Author::first()?->name);
		$this->assertEquals('10/04/1999', Author::first()?->dob->format('m/d/Y'));

		$response->assertRedirect($author->fresh()->path());
	}

	public function test_delete_author()
	{
		$this->post('/authors', [
			'name' => 'New Author Name',
			'dob' => '09/29/1999',
		]);

		$author = Author::latest()->first();

		$response = $this->delete($author->path());

		$this->assertCount(0, Author::all());
		$response->assertRedirect('/authors');
	}
}
