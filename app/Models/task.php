<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class task extends Model
{
    use HasFactory;
    protected $fillable = ['Ten','keHoach','thucHien','nguoiDeXuat','nguoiPhoiHop','moTaTask'
    ,'mucDo','ketQua','tinhTrang','luuY'];
}
