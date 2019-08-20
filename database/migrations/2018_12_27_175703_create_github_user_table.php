<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGithubUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('github_users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('github_id');
            $table->string('username')->unique()->comment('昵称');
            $table->string('name')->nullable()->comment('姓名');
            $table->string('email')->unique()->comment('邮箱');
            $table->string('avatar')->comment('头像');
            $table->string('github_url')->comment('git地址');
            $table->string('blog')->comment('博客地址')->nullable();
            $table->string('company')->comment('公司')->nullable();
            $table->text('original')->comment('original')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('github_users');
    }
}
