<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMessagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('messages', function(Blueprint $table)
		{
			$table->increments('id');
			$table->text('subject');
			$table->text('content');
			$table->integer('sender_id');
			$table->integer('recipient_id');
			$table->integer('thread_id')->default(0);
			$table->boolean('deleted_by_sender')->default(0);
			$table->boolean('deleted_by_recipient')->default(0);
			$table->boolean('read')->default(0);
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
		Schema::drop('messages');
	}

}
