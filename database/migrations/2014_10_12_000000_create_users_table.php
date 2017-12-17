<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nickname',32)->unique()->notnull();
            $table->string('username',32)->unique()->notnull();
            $table->string('password',255)->notnull();
            $table->integer('role_id')->default(1);
            $table->integer('last_login_at')->default(time());
            $table->string('last_login_ip',16)->default('');
            $table->integer('created_user_id')->default(1);
            $table->integer('updated_user_id')->default(1);
            $table->tinyInteger('flag')->defalut(1);
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
        Schema::dropIfExists('users');
    }
}
