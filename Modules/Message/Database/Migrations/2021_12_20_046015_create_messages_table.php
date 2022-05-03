<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            // $table->uuid('id')->primary();
            $table->id();
            $table->uuid('chat_room_id');
            $table->unsignedBigInteger('sender_id');
            // $table->unsignedBigInteger('receiver_id');
            $table->text('message')->nullable();
            $table->text('file')->nullable();
            $table->boolean('seen')->nullable()->default(false);
            $table->string('type')->nullable();
            $table->string('key')->nullable();
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
        Schema::dropIfExists('messages');
    }
}
