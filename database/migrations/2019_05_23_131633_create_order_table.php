<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('out_trade_no')->comment('系统订单号');
            $table->string('title')->comment('标题');
            $table->string('buyer_id')->nullable()->comment('购买人的id');
            $table->decimal('total_amount')->comment('金额');
            $table->tinyInteger('trade_status')->default(0)->comment('状态 0未支付 1已支付');
            $table->datetime('pay_time')->nullable()->comment('支付时间');
            $table->string('trade_no')->nullable()->comment('支付宝订单号');
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
        Schema::dropIfExists('orders');
    }
}
