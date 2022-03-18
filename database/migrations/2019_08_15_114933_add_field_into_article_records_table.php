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

class AddFieldIntoArticleRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('article_records', function (Blueprint $table) {
            $table->string('lat')->comment('纬度')->nullable();
            $table->string('lng')->comment('经度')->nullable();
            $table->string('nation', 32)->comment('国家')->nullable();
            $table->string('province', 32)->comment('省')->nullable();
            $table->string('city', 64)->comment('市')->nullable();
            $table->string('district', 64)->comment('区')->nullable();
            $table->integer('adcode')->comment('编号')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('article_records', function (Blueprint $table) {
            $table->dropColumn(['lat', 'lng', 'nation', 'province', 'city', 'district', 'adcode']);
        });
    }
}
