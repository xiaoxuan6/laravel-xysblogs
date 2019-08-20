<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSignIntoPackagistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('packagists', function (Blueprint $table) {
            $table->string('sign', 32)->comment('ฑ๊สถ');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('packagists', function (Blueprint $table) {
            $table->dropColumn('sign');
        });
    }
}
