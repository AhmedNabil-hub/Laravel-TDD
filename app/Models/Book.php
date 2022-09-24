<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
	use HasFactory;

	protected $guarded = [];

	public function path()
	{
		return '/books/' . $this->id;
	}

	public function setAuthorIdAttribute($value)
	{
		$this->attributes['author_id'] = (Author::firstOrCreate([
			'name' => $value,
		]))->id;
	}

	public function reservations()
	{
		return $this->hasMany(Reservation::class);
	}

	public function checkout(User $user)
	{
		$this->reservations()->create([
			'user_id' => $user->id,
			'checkedout_at' => now(),
			'checkedin_at' => null,
		]);
	}

	public function checkin(User $user)
	{
		$reservation = $this->reservations()
			->where('user_id', $user->id)
			->whereNotNull('checkedout_at')
			->whereNull('checkedin_at')
			?->first();

			if(is_null($reservation)) {
				throw new \Exception("Book is not checkedout", 1);
			}

		$reservation->update([
			'checkedin_at' => now(),
		]);
	}
}
