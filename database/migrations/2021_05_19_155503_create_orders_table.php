<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigincrements('id');
            $table->string('invoice')->unique();
            $table->biginteger('customer_id');
            $table->biginteger('user_id');
            $table->biginteger('branch_id');
            $table->integer('total');
            $table->string('payment_method');
            $table->string('pay');
            $table->string('pay_return');
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
