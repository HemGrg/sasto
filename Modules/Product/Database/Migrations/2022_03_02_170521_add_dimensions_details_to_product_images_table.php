<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDimensionsDetailsToProductImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_images', function (Blueprint $table) {
            $table->string('width')->nullable();
            $table->string('height')->nullable();
            $table->string('size')->nullable();
            $table->string('thumbnail_width')->nullable();
            $table->string('thumbnail_height')->nullable();
            $table->string('thumbnail_size')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_images', function (Blueprint $table) {

        });
    }
}
