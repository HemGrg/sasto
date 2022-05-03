<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('packages', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('order_id')->nullable()->constrained('orders')->cascadeOnDelete();
        //     $table->unsignedBigInteger('vendor_user_id')->nullable();
        //     $table->integer('package_no')->nullable();
        //     $table->integer('total_price');
        //     $table->enum('status', ['pending', 'processing', 'shipped', 'completed', 'cancelled', 'refunded'] )->default('pending');

        //     $table->softDeletes();
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('packages');
    }
}
