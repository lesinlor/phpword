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
            $table->engine = 'InnoDB';	//指定数据表的engine(Mysql).
            $table->charset = 'utf8';	//指定数据表的默认字符集(Mysql).
            $table->collation = 'utf8_unicode_ci';
            $table->increments('id')->comment('序号');
            $table->string('name', 60)->notnull()->default('')->comment('合同名称');
            $table->string('address', 512)->notnull()->default('')->comment('合同地址');
            $table->integer('type')->notnull()->default(1)->comment('合同类型'); //默认为其他
//            $table->float('money',13,2)->notnull()->defualt(0.00);
            $table->string('money',16)->notnull()->default(0)->comment('合同总价');
            $table->integer('st')->notnull()->default(0)->comment('合同开始时间');
            $table->integer('et')->notnull()->default(0)->comment('合同结束时间');
            $table->integer('section')->notnull()->default(0)->comment('合同期限');
            $table->smallInteger('grade')->notnull()->default(1)->comment('项目质量'); //1为优,2为良
            $table->string('concat',32)->notnull()->default('')->comment('联系人');
            $table->string('telephone',16)->notnull()->default('')->comment('电话');
            $table->integer('created_user_id')->notnull()->default(1);
            $table->integer('updated_user_id')->notnull()->default(1);
            //增加的字段2017-12-23
            $table->string('signature', 255)->notnull()->default('')->comment('签约方');
            $table->float('per_money',13,2)->default(0.00)->comment('合同单价');
            $table->string('batch', 255)->notnull()->default('')->comment('评审编号');
            $table->float('area',12,2)->notnull()->default(0.00)->comment('物业面积');
            $table->string('area_unit',10)->notnull()->default('m^2')->comment('面积单位');
            $table->string('charge',255)->notnull()->default('')->comment('分管情况');
            $table->string('subject',255)->notnull()->default('')->comment('标的情况');
            $table->string('place',128)->notnull()->default('')->comment('场所');
            $table->string('comment', 255)->notnull()->default('')->comment('备注');
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
