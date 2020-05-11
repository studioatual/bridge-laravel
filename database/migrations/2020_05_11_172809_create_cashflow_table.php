<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashflowTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cashflow', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->decimal('amount_payable', 18, 2);
            $table->decimal('amount_receivable', 18, 2);
            $table->decimal('day_balance', 18, 2);
            $table->decimal('accumalated_balance', 18, 2);
            $table->decimal('accumulated_pending', 18, 2);
            $table->date('cashflow_date');
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
        Schema::dropIfExists('cashflow');
    }
}
