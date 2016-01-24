<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateConsultasTecnicasTable extends Migration {

	public function up() {
		Schema::create('consultas_tecnicas', function (Blueprint $table) {
			//consulta_tecnicas
			$table->increments('id');
			$table->date('date')->nullable();
			$table->string('title')->nullable();
			$table->text('description')->nullable();
			$table->integer('cliente_id')->unsigned()->nullable();
			$table->integer('contact_id')->unsigned()->nullable();
			$table->integer('project_id')->unsigned()->nullable();
			$table->integer('project_stage_id')->unsigned()->nullable();
			$table->integer('project_discipline_id')->unsigned()->nullable();
			$table->string('color')->nullable();
			$table->integer('owner_id')->unsigned();
			$table->timestamps();
		});

	}

	public function down() {
		Schema::drop('consultas_tecnicas'); //consulta_tecnicas
	}
}