<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeStartEndDataTypeToDateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->dropColumn('step');
        });

        Schema::table('schedules', function (Blueprint $table) {
            $table->date('start')->change();
            $table->date('end')->change();
            $table->enum('step', ['document_check', 'audit'])->default('document_check')->after('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->dropColumn('step');
        });

        Schema::table('schedules', function (Blueprint $table) {
            $table->enum('step', ['document_check', 'audit'])->nullable()->after('status');
            $table->dateTime('end')->change();
            $table->dateTime('start')->change();
        });
    }
}
