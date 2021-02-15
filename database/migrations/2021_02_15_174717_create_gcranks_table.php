<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGcranksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gcranks', function (Blueprint $table) {
            $table->id();
            $table->string('guildName',512);
            $table->integer('guildLevel');
            $table->integer('point');
            $table->integer('winPoint');
            $table->integer('sourceCount');
            $table->integer('rankingInBattleTerm');
            $table->integer('gvgTimeType');   
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gcranks');
    }
}
