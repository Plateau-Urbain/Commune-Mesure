<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IndexLenghtId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (getenv('DB_CONNECTION') === 'sqlite') {
            DB::transaction(function () {
                DB::statement('ALTER TABLE places RENAME id TO id_old');
                DB::statement('ALTER TABLE places ADD COLUMN id CHAR(32) NOT NULL DEFAULT 0');
                DB::statement('UPDATE places SET id = id_old');
            });
        } else {
            DB::statement('ALTER TABLE places CHANGE id id CHAR(32)');
        }

        Schema::table('places', function (Blueprint $table) {
            if (Schema::hasColumn('places', 'id_old')) {
                $table->dropColumn('id_old');
            }
            $table->unique('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('places', function (Blueprint $table) {
            $table->string('id')->change();
        });
    }
}
