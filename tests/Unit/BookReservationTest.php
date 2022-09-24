<?php

namespace Tests\Unit;

use Faker\Factory;
use Tests\TestCase;
use App\Models\Book;
use App\Models\User;
use App\Models\Reservation;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookReservationTest extends TestCase
{
	use RefreshDatabase;
	/** @test */
	public function test_book_checkout()
	{
		$book = Book::factory()->create();
		$user = User::factory()->create();

		$book->checkout($user);

		$this->assertCount(1, Reservation::all());
		$this->assertEquals($user->id, Reservation::orderBy('id', 'DESC')->first()->user_id);
		$this->assertEquals($book->id, Reservation::orderBy('id', 'DESC')->first()->book_id);
		$this->assertEquals(now(), Reservation::orderBy('id', 'DESC')->first()->checkedout_at);
	}

	public function test_book_checkin()
	{
		$book = Book::factory()->create();
		$user = User::factory()->create();

		$book->checkout($user);
		$book->checkin($user);

		$this->assertCount(1, Reservation::all());
		$this->assertEquals($user->id, Reservation::orderBy('id', 'DESC')->first()->user_id);
		$this->assertEquals($book->id, Reservation::orderBy('id', 'DESC')->first()->book_id);
		$this->assertNotNull(Reservation::orderBy('id', 'DESC')->first()->checkedin_at);
		$this->assertEquals(now(), Reservation::orderBy('id', 'DESC')->first()->checkedin_at);
	}

	public function test_user_checkout_book_twice()
	{
		$book = Book::factory()->create();
		$user = User::factory()->create();

		$book->checkout($user);
		$book->checkin($user);

		$book->checkout($user);

		$this->assertCount(2, Reservation::all());
		$this->assertEquals($user->id, Reservation::orderBy('id', 'DESC')->first()->user_id);
		$this->assertEquals($book->id, Reservation::orderBy('id', 'DESC')->first()->book_id);
		$this->assertNull(Reservation::orderBy('id', 'DESC')->first()->checkedin_at);
		$this->assertEquals(now(), Reservation::orderBy('id', 'DESC')->first()->checkedout_at);

		$book->checkin($user);

		$this->assertCount(2, Reservation::all());
		$this->assertEquals($user->id, Reservation::orderBy('id', 'DESC')->first()->user_id);
		$this->assertEquals($book->id, Reservation::orderBy('id', 'DESC')->first()->book_id);
		$this->assertNotNull(Reservation::orderBy('id', 'DESC')->first()->checkedin_at);
		$this->assertEquals(now(), Reservation::orderBy('id', 'DESC')->first()->checkedin_at);
	}

	/** @test */
	public function test_exception_if_book_checkin_and_not_checkedout()
	{
		$this->expectException(Exception::class);

		$book = Book::factory()->create();
		$user = User::factory()->create();

		$book->checkin($user);
	}
}
