<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAbsentmembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absentmembers', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('member_id');
            $table->uuid('absent_id');
            $table->enum('absent',['present','permit','sick','alpha'])->default('alpha');
            $table->timestamps();

            $table->primary('id');
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
            $table->foreign('absent_id')->references('id')->on('absents')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('absentmembers');
    }
}
