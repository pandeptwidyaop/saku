<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberpaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('memberpayments', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('member_id');
            $table->uuid('payment_id');
            $table->enum('status',['paid','not_paid'])->default('not_paid');
            $table->timestamps();

            $table->primary('id');
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
            $table->foreign('payment_id')->references('id')->on('payments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('memberpayments');
    }
}
