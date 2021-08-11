<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class projectMana extends Model
{
    use HasFactory;
    protected $fillable = [
    'tenDuAn',
    'maDuAn',
    'tenCdt',
    'moTaDuAn',
    'ngayBatDau',
    'ngayKetThuc',
    'ngayKetThucThucTe',
    'trangThai',
    'nhanSuChinh',
    'nhanSuLienQuan',];
}
