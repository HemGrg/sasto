<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::create('orders', function (Blueprint $table) {
            $table->id()->from(20000);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('vendor_id')->nullable();
            $table->double('subtotal_price', 15, 2)->nullable();
            $table->double('shipping_charge', 8, 2)->nullable();
            $table->double('total_price', 15, 2)->nullable();
            $table->uuid('deal_id')->nullable();
            $table->text('order_note')->nullable();
            $table->text('track_no')->nullable();
            $table->string('payment_type')->nullable();
            $table->enum('status', ['pending', 'processing', 'shipped', 'completed', 'cancelled', 'refunded'] )->default('pending');
            $table->string('payment_status')->nullable();
            $table->string('esewa_ref_id')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
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
