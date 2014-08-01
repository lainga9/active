<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddCreditsColumnToInstructorsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users_instructors', function(Blueprint $table)
		{
			$table->integer('credits')->default(3);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users_instructors', function(Blueprint $table)
		{
			$table->dropColumn('credits');
		});
	}

}
