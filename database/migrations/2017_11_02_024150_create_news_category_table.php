<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news_category', function (Blueprint $table) {
            $table->engine='InnoDB';
            $table->increments('id');
            $table->unsignedInteger('sort')->default(0)->comment('排序');
            $table->string('cname')->nullable()->comment('分类名称');
            $table->tinyInteger('status')->default(1)->comment('状态：-1删除，0审核/禁用，1启用');
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
        Schema::dropIfExists('news_category');
    }
}
