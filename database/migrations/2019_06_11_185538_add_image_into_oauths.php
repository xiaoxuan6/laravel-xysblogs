<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddImageIntoOauths extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('oauths', function (Blueprint $table) {
            $table->string('image', 64)->default('github/xiaoxuan.png')->comment('ͷ��');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('oauths', function (Blueprint $table) {
            //
        });
    }
}
