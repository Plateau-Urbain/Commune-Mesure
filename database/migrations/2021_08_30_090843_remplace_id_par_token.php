<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemplaceIdParToken extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //change le type de la colonne id en varchar
        Schema::table('places', function (Blueprint $table){
            $table->string('id')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //change le type de la colonne id en uuid
        Schema::table('places', function (Blueprint $table){
            $table->uuid('id')->change();
        });
    }
}
