<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEmailFileTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('email_file', function (Blueprint $table) {
			$table->increments('id')->index();
			$table->integer('email_message_id')->unsigned();
			$table->integer('file_entry_id')->unsigned();
		});
		Schema::table('email_file', function (Blueprint $table) {
			$table->foreign('email_message_id')->references('id')->on('email_messages')
				->onDelete('cascade')
				->onUpdate('cascade');
			$table->foreign('file_entry_id')->references('id')->on('file_entries')
				->onDelete('cascade')
				->onUpdate('cascade');
		});
	}
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('email_file', function (Blueprint $table) {
			$table->dropForeign('email_file_email_message_id_foreign');
			$table->dropForeign('email_file_file_entry_id_foreign');
		});
		Schema::drop('email_file');
	}
}
