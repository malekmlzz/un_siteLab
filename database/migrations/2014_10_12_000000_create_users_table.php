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
            $table->char('full_name')->nullable();
            $table->char('national_code' , 10)->nullable();
            $table->string('docter_code')->nullable();
            $table->char('phone_number')->nullable();
            $table->enum('role' ,['laboratory' , 'sonography' , 'docter' , 'admin'])->nullable();
            $table->string('center_number')->nullable();
            $table->string('email')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->tinyInteger('is_approved')->default(0);
            $table->rememberToken();
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
