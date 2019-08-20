<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackagistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packagists', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->comment('����');
            $table->string('image')->comment('ͼƬ');
            $table->string('url')->comment('gitHub ��ַ');
            $table->string('composer_url')->comment('composer ��ַ');
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
        Schema::dropIfExists('packagists');
    }
}
