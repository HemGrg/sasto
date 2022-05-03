<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->unsignedBigInteger('product_category_id')->nullable();
            $table->double('shipping_charge', 15, 2)->nullable();
            $table->text('highlight')->nullable();
            $table->text('description')->nullable();
            $table->string('video_link')->nullable();
            $table->string('image')->nullable();
            $table->boolean('status')->default(true);          
            $table->boolean('is_top')->default(false);
            $table->boolean('is_new_arrival')->default(false);

            //Quick Details
            $table->json('overview')->nullable();

            //SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_keyword')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keyphrase')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('SET NULL');
            $table->unsignedBigInteger('vendor_id')->nullable();
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('CASCADE');
            $table->foreign('product_category_id')->references('id')->on('product_categories')->onDelete('CASCADE');
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
        Schema::dropIfExists('products');
    }
}
