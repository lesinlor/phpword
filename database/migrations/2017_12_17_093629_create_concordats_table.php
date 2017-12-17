<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConcordatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('concordats', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 60)->unique()->notnull()->default('');
            $table->string('address', 512)->notnull()->default('');
            $table->float('money')->notnull()->defualt(0.00);
            $table->integer('st')->notnull()->default(0);
            $table->integer('et')->notnull()->default(0);
            $table->smallInteger('grade')->notnull()->default(1); //1为优,2为良
            $table->string('concat',32)->notnull()->default('');
            $table->string('telephone',16)->notnull()->default('');
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
        Schema::dropIfExists('concordats');
    }
}
