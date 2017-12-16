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
<<<<<<< HEAD
            $table->string('nickname',32)->unique()->notnull();
            $table->string('password',255)->notnull();
            $table->integer('role_id')->default(1);
            $table->integer('last_login_at')->time(time());
            $table->string('last_login_ip',16)->default('');
            $table->integer('created_user_id')->default(1);
            $table->integer('updated_user_id')->default(1);
            $table->tinyInteger('flag')->defalut(1);
=======
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
>>>>>>> 6e0e8259bbaf1b197e2f92cfdab0a75cb5254a9c
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
