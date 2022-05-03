<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuotationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->string('purchase')->nullable();
            $table->string('quantity')->nullable();
            $table->string('unit')->nullable();
            $table->text('specifications')->nullable();
            $table->string('image1')->nullable();
            $table->string('image2')->nullable();
            $table->string('image3')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile_num')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('ship_to')->nullable();
            $table->string('expected_price')->nullable();
            $table->string('expected_del_time')->nullable();
            $table->string('other_contact')->nullable();
            $table->string('link')->nullable();

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
        Schema::dropIfExists('quotations');
    }
}
