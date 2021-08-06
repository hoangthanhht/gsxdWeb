<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToReportDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('report_days', function (Blueprint $table) {
            $table->text('tenDuan')->nullable();
            $table->text('diaDiem')->nullable();
            $table->text('chuDauTu')->nullable();
            $table->text('banQuanLy')->nullable();
            $table->text('nhaThau')->nullable();
            $table->text('tvtk')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('report_days', function (Blueprint $table) {
            $table->dropColumn('tenDuan');
            $table->dropColumn('diaDiem');
            $table->dropColumn('chuDauTu');
            $table->dropColumn('banQuanLy');
            $table->dropColumn('nhaThau');
            $table->dropColumn('tvtk');
        });
    }
}
