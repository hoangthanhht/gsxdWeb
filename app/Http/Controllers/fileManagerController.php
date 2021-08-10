<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\fileManager;
class fileManagerController extends Controller
{
    public function store(Request $request)
    {
        $File = fileManager::create([
            //$ArticlePost = DB::table('article_posts')->insert([
                'duAn'=>$request->duAn,
                'loaiHoSo'=>$request->loaiHoSo,
                'tenHoSo'=>$request->tenHoSo,
                'soLuong'=>$request->soLuong,
                'ngayNhan'=>$request->ngayNhan,
                'ngayTra'=>$request->ngayTra,
                'lanKiemTra'=>$request->lanKiemTra,
                'ketQua'=>$request->ketQua,
                'lyDoKhongDat'=>$request->lyDoKhongDat,
                'noiDungThayDoiTk'=>$request->noiDungThayDoiTk,
                'nguyenNhanThayDoiTk'=>$request->nguyenNhanThayDoiTk,
                'nguoiPheDuyet'=>$request->nguoiPheDuyet,
                'yKienTVGS'=>$request->yKienTVGS,
        ]);
        if($File) {
            return response()->json([
                'success' => true,
                'msg' => 'Tạo hồ sơ thành công',
            ]);
        }else{
            return response()->json([
                'success' => false,
                'msg' => 'Tạo hồ sơ không thành công',
            ]);
        }
    }

    public function show ()
    {
        $file = fileManager::paginate(20);
        // $posts = auth()->user()->posts;

        return response()->json($file);
    }
}
