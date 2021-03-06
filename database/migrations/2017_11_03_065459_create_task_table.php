<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task', function (Blueprint $table) {
            $table->engine='InnoDB';
            $table->increments('id');
            $table->string('title')->nullable()->comment('关键字');
            $table->unsignedInteger('num')->default(1)->comment('需要次数');
            $table->unsignedInteger('price')->default(1)->comment('奖励种子');
            $table->text('describe')->comment('描述');
            $table->unsignedInteger('sort')->default(0)->comment('排序');
            $table->unsignedInteger('stoptime')->nullable()->comment('结束时间');
            $table->tinyInteger('status')->default(1)->comment('状态：-1删除，0审核，1启用');
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
        Schema::dropIfExists('task');
    }
}
