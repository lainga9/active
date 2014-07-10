<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersInstructorsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users_instructors', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('phone');
			$table->string('mobile');
			$table->string('postcode');
			$table->text('bio');
			$table->string('website');
			$table->string('facebook');
			$table->string('twitter');
			$table->string('youtube');
			$table->string('google');
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users_instructors');
	}

}
