<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('标题');
            $table->string('user_id')->comment('用户id');
            $table->string('label_id')->comment('标签');
            $table->text('content')->comment('内容');
            $table->tinyInteger('status')->comment('状态 1正常 2黑名单')->default(1);
            $table->integer('view')->comment('浏览量')->default(0);
            $table->integer('point_num')->comment('点赞数')->default(0);
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
        Schema::dropIfExists('articles');
    }
}
