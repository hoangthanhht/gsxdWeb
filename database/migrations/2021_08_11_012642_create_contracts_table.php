<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->text('tenHopDong')->nullable();
            $table->text('loaiHopDong')->nullable();
            $table->text('duAn')->nullable();
            $table->text('giaTriHD')->nullable();
            $table->text('nhanSuLienQuan')->nullable();
            $table->text('batDau')->nullable();
            $table->text('ketThuc')->nullable();
            $table->text('donVi')->nullable();
            $table->text('khoiLuong')->nullable();
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
        Schema::dropIfExists('contracts');
    }
}
