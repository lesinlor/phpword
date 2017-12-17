<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table){
           $table->increments('id');
           $table->string('name',32)->notnull()->unique();
           $table->string('icon',255)->notnull()->default('');
           $table->string('uri',255)->notnull()->default('');
           $table->integer('pid')->notnull()->default(0);
           $table->tinyInteger('flag')->notnull()->default(1);
           $table->integer('created_user_at')->default(0);
           $table->integer('updated_user_at')->default(0);
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
        Schema::dropIfExists('menus');
    }
}
