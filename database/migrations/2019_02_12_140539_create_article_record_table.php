<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleRecordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_records', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ip', 64)->comment('浏览者使用的ip');
            $table->integer('article_id')->comment('文章id');
            $table->integer('status')->default(0)->comment('是否点赞 0否 1是');
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
        Schema::dropIfExists('article_records');
    }
}
