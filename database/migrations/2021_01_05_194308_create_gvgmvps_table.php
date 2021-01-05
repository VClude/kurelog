<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGvgmvpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gvgmvps', function (Blueprint $table) {
            $table->id();
            $table->integer('gvgDataId');
            $table->enum('typeMvp', ['Lifeforce', 'Recover','Ally ATK Support', 'Ally DEF Support', 'Enemy ATK Debuff','Enemy DEF Debuff','Combo']);
            $table->string('nameA',50);
            $table->string('nameB',50);
            $table->integer('rank');
            $table->integer('userIdA');
            $table->integer('userIdB');
            $table->integer('valueA');
            $table->integer('valueB');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gvgmvps');
    }
}
