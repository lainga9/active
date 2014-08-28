<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddSocialColumnsToUsersClientsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users_clients', function(Blueprint $table)
		{
			$table->string('twitter');
			$table->string('facebook');
			$table->string('youtube');
			$table->string('instagram');
			$table->string('website');
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
			$table->dropColumn('twitter', 'facebook', 'youtube', 'instagram', 'website');
		});
	}

}
