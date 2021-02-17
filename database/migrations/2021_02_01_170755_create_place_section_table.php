<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlaceSectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('place_section', function (Blueprint $table) {
            $table->id();
            $table->uuid('place_id');
            $table->integer('section_id');
            $table->boolean('visible')->default(true);
            $table->timestamps();

            if (env('DB_CONNECTION') === 'sqlite' && env('DB_FOREIGN_KEYS') === true) {
                $table->foreign('place_id')->reference('id')->on('places')->onDelete('cascade');
                $table->foreign('section_id')->reference('id')->on('sections')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('place_section');
    }
}
