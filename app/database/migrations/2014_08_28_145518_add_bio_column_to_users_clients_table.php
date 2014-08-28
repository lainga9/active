<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddBioColumnToUsersClientsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users_clients', function(Blueprint $table)
		{
			$table->text('bio');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users_clients', function(Blueprint $table)
		{
			$table->dropColumn('bio');			
		});
	}

}