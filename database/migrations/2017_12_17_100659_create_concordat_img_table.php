<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConcordatImgTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('concordat_img', function (Blueprint $table){
            $table->increments('id');
            $table->integer('con_id')->notnull();
            $table->integer('sort')->notnull();
            $table->string('content')->notnull();
            $table->integer('created_user_id')->default(0);
            $table->integer('updated_user_id')->default(0);
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
        Schema::dropIfExists('concordat_img');
    }
}
