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
            $table->integer('concordat_id')->notnull();
            $table->string('directory', 255)->notnull()->defalut('/');
            $table->integer('sort')->notnull();
            $table->string('path')->notnull();
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
