<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPhonesAndSkypeToClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clientes', function (Blueprint $table) {            
            $table->text('phones2')->nullable()->after('phones');
            $table->text('phones3')->nullable()->after('phones2');
            $table->text('skype')->nullable()->after('phones3');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clientes', function (Blueprint $table) {            
            $table->dropColumn('phones2');
            $table->dropColumn('phones3');
            $table->dropColumn('skype');
        });
    }
}
