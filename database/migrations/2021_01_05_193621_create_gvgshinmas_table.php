<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGvgshinmasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gvgshinmas', function (Blueprint $table) {
            $table->id();
            $table->integer('gvgDataId');
            $table->integer('artMstId');
            $table->integer('guildACount');
            $table->integer('guildBCount');
            $table->integer('ultimateArtMethodMstId');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gvgshinmas');
    }
}
