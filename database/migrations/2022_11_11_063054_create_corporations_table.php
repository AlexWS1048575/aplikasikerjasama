<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('corporations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('title');
            $table->string('phonenumber')->nullable();
            $table->string('document_no');
            $table->date('assignment_date');
            $table->text('summary')->nullable();
            $table->integer('duration');
            $table->string('pic')->nullable();
            $table->string('attachment')->nullable();
            $table->integer('status_id')->default('1');
            $table->integer('type_id');
            $table->integer('corporationtype_id')->nullable();
            $table->integer('durationtype_id');
            $table->integer('created_by');
            $table->integer('updated_by');
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
        Schema::dropIfExists('corporations');
    }
};
