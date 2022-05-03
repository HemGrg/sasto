<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdvertisementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advertisements', function (Blueprint $table) {
            $table->id();
            $table->text('title')->nullable();
            $table->string('slug')->unique();
            $table->string('image')->nullable();
            $table->enum('ad_page', ['home', 'category', 'product detail', 'order', 'dashboard'])->default('home');
            $table->enum('ad_position', ['full_last', 'after banner', 'left side', 'right side', 'middle'])->default('full_last');
            
            $table->string('link')->nullable();
            $table->enum('status', ['Publish', 'Unpublish'])->default('Publish');
            $table->unsignedBigInteger('added_by')->nullable();
            $table->foreign('added_by')->references('id')->on('users')->onDelete('SET NULL');
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
        Schema::dropIfExists('advertisements');
    }
}
