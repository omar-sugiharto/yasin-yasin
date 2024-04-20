<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RecreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('documents');

        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('name');
            $table->string('img');
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
        Schema::dropIfExists('documents');

        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('akta')->nullable();
            $table->string('sk_kemenkumham')->nullable();
            $table->string('npwp')->nullable();
            $table->string('skdu')->nullable();
            $table->string('siu')->nullable();
            $table->string('tdp')->nullable();
            $table->enum('status', ['incomplete', 'rejected', 'waiting', 'accepted']);
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
