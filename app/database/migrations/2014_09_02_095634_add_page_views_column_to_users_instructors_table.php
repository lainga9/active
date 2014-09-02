<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddPageViewsColumnToUsersInstructorsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users_instructors', function(Blueprint $table)
		{
			$table->integer('page_views');
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
			$table->dropColumn('page_views');			
		});
	}

}