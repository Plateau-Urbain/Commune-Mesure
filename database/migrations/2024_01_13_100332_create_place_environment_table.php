<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Query\Expression;

class CreatePlaceEnvironmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('place_environment', function (Blueprint $table) {
            $table->uuid('id')->unique()->autoIncrement();
            $table->foreignUuid('place_id')->constrained()->onDelete('cascade');
            $table->boolean('visible')->default(true);
            $table->json('data')->default(new Expression('(JSON_ARRAY())'));
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
        Schema::dropIfExists('place_environment');
    }
}
