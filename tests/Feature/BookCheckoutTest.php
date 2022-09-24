<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Book;
use App\Models\User;
use App\Models\Reservation;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookCheckoutTest extends TestCase
{
	use RefreshDatabase;

	/** @test */
	public function test_book_checkout()
	{
		$this->withoutExceptionHandling();

		$book = Book::factory()->create();
		$user = User::factory()->create();

		$this->actingAs($user)
			->post('/checkout/' . $book->id);

		$this->assertCount(1, Reservation::all());
		$this->assertEquals($user->id, Reservation::orderBy('id', 'DESC')->first()->user_id);
		$this->assertEquals($book->id, Reservation::orderBy('id', 'DESC')->first()->book_id);
		$this->assertEquals(now(), Reservation::orderBy('id', 'DESC')->first()->checkedout_at);
	}

	public function test_only_auth_user_can_book_checkout()
	{
		$this->withoutExceptionHandling();

		$book = Book::factory()->create();
		// $user = User::factory()->create();

		$this->post('/checkout/' . $book->id)
			->assertRedirect('/login');

		$this->assertCount(0, Reservation::all());
	}

	public function test_if_book_exists()
	{
		// $this->expectException(ModelNotFoundException::class);

		$user = User::factory()->create();

		$this->actingAs($user)
			->post('/checkout/123')
			->assertStatus(404);

		$this->assertCount(0, Reservation::all());
	}

	public function test_book_checkin()
	{
		$this->withoutExceptionHandling();

		$book = Book::factory()->create();
		$user = User::factory()->create();

		$this->actingAs($user)
			->post('/checkout/' . $book->id);

		$this->actingAs($user)
			->post('/checkin/' . $book->id);

		$this->assertCount(1, Reservation::all());
		$this->assertEquals($user->id, Reservation::orderBy('id', 'DESC')->first()->user_id);
		$this->assertEquals($book->id, Reservation::orderBy('id', 'DESC')->first()->book_id);
		$this->assertEquals(now(), Reservation::orderBy('id', 'DESC')->first()->checkedin_at);
	}

	public function test_only_auth_user_can_book_checkin()
	{
		$this->withoutExceptionHandling();

		$book = Book::factory()->create();
		$user = User::factory()->create();

		$this->actingAs($user)
			->post('/checkout/' . $book->id);

		auth()->logout();

		$this->post('/checkin/' . $book->id)
			->assertRedirect('/login');

		$this->assertCount(1, Reservation::all());
		$this->assertNull(Reservation::orderBy('id', 'DESC')->first()->checkedin_at);
	}

	public function test_checkout_before_book_checkin()
	{
		$book = Book::factory()->create();
		$user = User::factory()->create();

		$this->actingAs($user)
			->post('/checkin/' . $book->id)
			->assertStatus(404);

		$this->assertCount(0, Reservation::all());
	}
}
