<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGvgnmlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gvgnmlogs', function (Blueprint $table) {
            $table->id();
            $table->timestamp('actTime');
            $table->integer('guildDataId');
            $table->integer('gvgDataId');
            $table->integer('gvgHistoryId');
            $table->boolean('isOwnGuild');
            $table->longText('readableText');
            $table->integer('userId');
            $table->string('userName',50);          
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gvgnmlogs');
    }
}
