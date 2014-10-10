<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddExtraStripeColumnsToUsers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function(Blueprint $table)
		{
			$table->string('stripe_connect_code');
			$table->string('stripe_access_token');
			$table->string('stripe_refresh_token');
			$table->string('stripe_publishable_key');
			$table->string('stripe_user_id');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function(Blueprint $table)
		{
			$table->dropColumn('stripe_connect_code', 'stripe_access_token', 'stripe_refresh_token', 'stripe_publishable_key', 'stripe_user_id');
		});
	}

}