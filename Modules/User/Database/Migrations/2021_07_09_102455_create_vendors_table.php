<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->string('shop_name')->nullable();
            $table->string('slug');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            // Category
            $table->enum('category',['local_seller','international_seller']);
            // Plan
            $table->enum('plan',['basic_plan','standard_plan','premium_plan']);
            // General Information
            $table->string('company_address')->nullable();
            $table->string('company_email')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('image')->nullable();
            $table->string('business_type')->nullable();
            $table->string('product_category')->nullable();
            $table->text('description')->nullable();

            //commission
            $table->string('commission_rate')->nullable();

            //country
            $table->unsignedBigInteger('country_id')->nullable();
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');

            // Payment Information
            $table->string('bank_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('branch_name')->nullable();
            $table->string('name_on_bank_acc')->nullable();
            $table->string('bank_info_image')->nullable();

            $table->tinyInteger('remember_me')->default(1)->nullable();

            $table->enum('status',[1,0])->default(1);

            $table->softDeletes();
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
        Schema::dropIfExists('vendors');
    }
}
