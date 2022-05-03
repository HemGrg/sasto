<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBecomePartnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('become_partners', function (Blueprint $table) {
            $table->id();
            $table->string('company_name')->nullable();
            $table->string('company_email')->nullable();
            $table->string('address')->nullable();
            $table->string('company_phone')->nullable();
            $table->string('eastablished_year')->nullable();
            $table->string('company_web')->nullable();
            $table->unsignedBigInteger('partner_type_id')->nullable();
            $table->foreign('partner_type_id')->references('id')->on('partner_types')->onDelete('CASCADE');
            $table->string('full_name')->nullable();
            $table->string('email')->nullable();
            $table->string('designation')->nullable();
            $table->string('phone')->nullable();
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
        Schema::dropIfExists('become_partners');
    }
}
