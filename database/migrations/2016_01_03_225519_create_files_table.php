<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFilesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {

		Schema::create('file_entries', function (Blueprint $table) {
			$table->increments('id');
			$table->string('filename');
			$table->string('mime');
			$table->string('original_filename');
			$table->integer('owner_id')->unsigned()->nullable();
			$table->timestamps();
		});

		Schema::table('file_entries', function (Blueprint $table) {
			$table->foreign('owner_id')->references('id')->on('users')
				->onDelete('set null')
				->onUpdate('cascade');
		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('file_entries', function (Blueprint $table) {
			$table->dropForeign('file_entries_owner_id_foreign');
		});
		Schema::drop('file_entries');
	}
}
