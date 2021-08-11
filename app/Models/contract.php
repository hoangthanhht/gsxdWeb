<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class contract extends Model
{
    use HasFactory;
    protected $fillable = [
    'tenHopDong',
    'loaiHopDong',
    'duAn',
    'giaTriHD',
    'nhanSuLienQuan',
    'batDau',
    'ketThuc',
    'donVi',
    'khoiLuong', ];
}
