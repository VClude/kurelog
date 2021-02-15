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
            $table->timestamp('guildName');
            $table->integer('guildLevel');
            $table->integer('point');
            $table->integer('winPoint');
            $table->boolean('sourceCount');
            $table->longText('rankingInBattleTerm');
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
