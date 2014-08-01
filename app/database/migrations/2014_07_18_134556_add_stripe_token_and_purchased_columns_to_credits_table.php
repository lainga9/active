<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddStripeTokenAndPurchasedColumnsToCreditsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('credits', function(Blueprint $table)
		{
			$table->string('stripe_token');
			$table->string('purchased');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('credits', function(Blueprint $table)
		{
			$table->dropColumn('stripe_token', 'purchased');
		});
	}

}
