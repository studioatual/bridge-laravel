<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStandardUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('standard_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('group_id');
            $table->foreign('group_id')->references('id')->on('standard_groups')->onDelete('cascade');
            $table->string('name', 100);
            $table->integer('code')->nullable();
            $table->string('cpf_cnpj', 14)->unique();
            $table->string('username', 100);
            $table->string('email', 100)->unique();
            $table->string('password');
            $table->string('hash')->nullable();
            $table->boolean('active');
            $table->boolean('admin');
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
        Schema::dropIfExists('standard_users');
    }
}
