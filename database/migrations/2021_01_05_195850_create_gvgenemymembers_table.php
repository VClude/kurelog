<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGvgenemymembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gvgenemymembers', function (Blueprint $table) {
            $table->id();
            $table->integer('gvgDataId');
            $table->integer('maxHp');
            $table->integer('userId');
            $table->string('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gvgenemymembers');
    }
}
