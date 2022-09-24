<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up()
	{
		Schema::create('reservations', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('user_id');
			$table->unsignedBigInteger('book_id');
			$table->timestamp('checkedout_at');
			$table->timestamp('checkedin_at')->nullable();
			$table->timestamps();
		});
	}

	function down()
	{
		Schema::dropIfExists('reservations');
	}
};
