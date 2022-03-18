<?php
/**
 * This file is part of PHP CS Fixer.
 *
 * (c) vinhson <15227736751@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiscussTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discuss', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('article_id')->comment('文章id');
            $table->unsignedInteger('oauth_id')->comment('oauths_id');
            $table->text('comment')->comment('评论内容');
            $table->tinyInteger('status')->default(1)->comment('状态 1：显示 2 不显示 3 置顶');
            $table->tinyInteger('type')->default(0)->comment('是否为作者 0不是 1是');
            $table->tinyInteger('pid')->default(0)->comment('父级ID');
            $table->tinyInteger('ppid')->default(0)->comment('祖籍ID');
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
        Schema::dropIfExists('discuss');
    }
}
