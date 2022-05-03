<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->morphs('addressable');
            $table->string('type')->nullable(); // shipping and billing for order
            $table->string('full_name')->nullable();
            $table->string('company_name')->nullable();
            $table->string('vat')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('street_address')->nullable();
            $table->string('nearest_landmark')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();

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
        Schema::dropIfExists('addresses');
    }
}
