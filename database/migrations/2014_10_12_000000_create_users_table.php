<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone_num')->nullable();
            $table->string('image')->nullable();
            $table->string('designation')->nullable();
            $table->text('api_token')->nullable();
            $table->string('password');
            $table->string('activation_link')->nullable();
            $table->string('otp')->nullable();

            // $table->string('role')->nullable()->comment(' super-admin | admin | employer | jobseeker ');
            $table->text('access_level')->nullable();

            $table->tinyInteger('publish')->default(0)->nullable();
            $table->tinyInteger('is_active')->default(0)->nullable();
            $table->tinyInteger('verified')->default(0)->nullable();
            $table->enum('vendor_type', ['approved', 'new', 'suspended'])->default('new');

            $table->tinyInteger('remember_password')->default(0)->nullable();
            $table->tinyInteger('terms_condition')->default(1)->nullable();
            $table->string('username')->unique()->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
