<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class fileManager extends Model
{
    use HasFactory;
    protected $fillable = [
    'duAn',
    'loaiHoSo',
    'kyHieuHoSo',
    'tenHoSo',
    'soLuong',
    'ngayNhan',
    'ngayTra',
    'lsnKiemTra',
    'ketQua',
    'lyDoKhongDat',
    'noiDUngThayDoiTk',
    'nguyenNhanThayDoiTk',
    'nguoiPheDuyet',
    'yKienTVGS'
    ,'pathFile'];
}
