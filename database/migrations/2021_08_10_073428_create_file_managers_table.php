<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileManagersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_managers', function (Blueprint $table) {
            $table->id();
            $table->text('loaiHoSo')->nullable();
            $table->text('kyHieuHoSo')->nullable();
            $table->text('duAn')->nullable();
            $table->text('tenHoSo')->nullable();
            $table->text('soLuong')->nullable();
            $table->text('ngayNhan')->nullable();
            $table->text('ngayTra')->nullable();
            $table->text('lanKiemTra')->nullable();
            $table->text('ketQua')->nullable();
            $table->text('lyDoKhongDat')->nullable();
            $table->text('noiDungThayDoiTk')->nullable();
            $table->text('nguyenNhanThayDoiTk')->nullable();
            $table->text('nguoiPheDuyet')->nullable();
            $table->text('yKienTVGS')->nullable();
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
        Schema::dropIfExists('file_managers');
    }
}
