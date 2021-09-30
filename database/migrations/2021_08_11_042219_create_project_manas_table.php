<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectManasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_manas', function (Blueprint $table) {
            $table->id();
            $table->text('tenDuAn')->nullable();
            $table->text('maDuAn')->nullable();
            $table->text('tenCdt')->nullable();
            $table->text('moTaDuAn')->nullable();
            $table->text('ngayBatDau')->nullable();
            $table->text('ngayKetThuc')->nullable();
            $table->text('ngayKetThucThucTe')->nullable();
            $table->text('trangThai')->nullable();
            $table->text('nhanSuChinh')->nullable();
            $table->text('nhanSuLienQuan')->nullable();
            $table->text('pathFile'); 
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
        Schema::dropIfExists('project_manas');
    }
}
