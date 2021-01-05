<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGvgtopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gvgtops', function (Blueprint $table) {
            $table->id();
            $table->integer('gvgDataId');
            $table->timestamp('battleEndTime')->nullable();;
            $table->timestamp('battleStartTime')->nullable();;
            $table->integer('guildDataCountryCodeA');
            $table->integer('guildDataCountryCodeB');
            $table->integer('guildDataIdA');
            $table->integer('guildDataIdB');
            $table->string('guildDataNameA',50);
            $table->string('guildDataNameB',50);
            $table->integer('totalGuildPointA');
            $table->integer('totalGuildPointB');
            $table->integer('totalGuildPowerA');
            $table->integer('totalGuildPowerB');
            $table->integer('enemyComboCount');
            $table->integer('selfComboCount');
            $table->integer('enemySiegeWinCount');
            $table->integer('selfSiegeWinCount');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gvgtops');
    }
}
