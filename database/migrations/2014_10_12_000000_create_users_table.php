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
            $table->string('job_title');
            $table->string('department');
            $table->string('site');
            $table->unsignedBigInteger('manager_id')->nullable();
            $table->unsignedBigInteger('HOD_id')->nullable();
            $table->string('site');
            $table->string('HOD_email');
            $table->boolean('role_admin')->default(0);
            $table->boolean('role_manager')->default(0);
            $table->boolean('role_HOD')->default(0);
            $table->boolean('status')->default(1);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
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
