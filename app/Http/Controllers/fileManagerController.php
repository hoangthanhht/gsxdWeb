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
                'kyHieuHoSo'=>$request->kyHieuHoSo,
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

    public function getFileById ($fileManager_id)
    {
        $fileManager = fileManager::find($fileManager_id);
        // $posts = auth()->user()->posts;

        return response()->json($fileManager);
    }

    public function update(Request $request, $id)
    {
        $fileManager = fileManager::find($id);
 
        if (!$fileManager) {
            return response()->json([
                'success' => false,
                'msg' => 'File not found'
            ], 400);
        }
 
        $updated = $fileManager->fill($request->all())->save();
 
        if ($updated)
            return response()->json([
                'success' => true,
                'msg' => 'Update thành công'
            ]);
        else
            return response()->json([
                'success' => false,
                'msg' => 'Post can not be updated'
            ], 500);
    }
}
