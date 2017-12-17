<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConcordatTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('concordat_type', function (Blueprint $table){
            $table->increments('id');
            $table->string('name')->unique()->notnull()->default('');
            $table->tinyInteger('flag')->default(1);
            $table->integer('created_user_id')->notnull()->default(0);
            $table->integer('updated_user_id')->notnull()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('concordat_type');
    }
}
