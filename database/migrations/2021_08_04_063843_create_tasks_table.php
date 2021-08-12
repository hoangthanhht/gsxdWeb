<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->text('Ten'); 
            $table->text('keHoach')->nullable(); 
            $table->text('thucHien')->nullable(); 
            $table->text('nguoiDeXuat')->nullable(); 
            $table->text('duanLienQuan')->nullable(); 
            $table->text('nguoiPhoiHop')->nullable(); 
            $table->text('moTaTask')->nullable(); 
            $table->text('mucDo')->nullable(); 
            $table->text('ketQua')->nullable(); 
            $table->text('tinhTrang')->nullable(); 
            $table->text('luuY')->nullable(); 
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
        Schema::dropIfExists('tasks');
    }
}
