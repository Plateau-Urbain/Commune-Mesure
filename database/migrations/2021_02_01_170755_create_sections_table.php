<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->uuid('place_id');
            $table->string('section');
            $table->boolean('visible')->default(true);
            $table->timestamps();

            if (env('DB_CONNECTION') === 'sqlite' && env('DB_FOREIGN_KEYS') === true) {
                $table->foreign('place_id')->reference('id')->on('places')->onDelete('cascade');
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
        Schema::dropIfExists('sections');
    }
}
