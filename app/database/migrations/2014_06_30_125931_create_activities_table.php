<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateActivitiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('activities', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->integer('places');
			$table->text('description');
			$table->text('street_address');
			$table->text('town');
			$table->text('postcode');
			$table->string('time');
			$table->string('date');
			$table->float('cost');
			$table->integer('user_id');
			$table->integer('level_id');
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
		Schema::drop('activities');
	}

}
