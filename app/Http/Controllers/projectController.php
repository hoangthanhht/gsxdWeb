<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\projectMana;
class projectController extends Controller
{
    public function store(Request $request)
    {
        $projectMana = projectMana::create([
            //$ArticlePost = DB::table('article_posts')->insert([
                'tenDuAn'=>$request->tenDuAn,
                'maDuAn'=>$request->maDuAn,
                'tenCdt'=>$request->tenCdt,
                'moTaDuAn'=>$request->moTaDuAn,
                'ngayBatDau'=>$request->ngayBatDau,
                'ngayKetThuc'=>$request->ngayKetThuc,
                'ngayKetThucThucTe'=>$request->ngayKetThucThucTe,
                'trangThai'=>$request->trangThai,
                'nhanSuChinh'=>$request->nhanSuChinh,
                'nhanSuLienQuan'=>$request->nhanSuLienQuan,
        ]);
        if($projectMana) {
            return response()->json([
                'success' => true,
                'msg' => 'Tạo dự án thành công',
            ]);
        }else{
            return response()->json([
                'success' => false,
                'msg' => 'Tạo dự án không thành công',
            ]);
        }
    }

    public function show ()
    {
        $projectMana = projectMana::paginate(20);
        // $posts = auth()->user()->posts;

        return response()->json($projectMana);
    }

    public function getProjectName ()
    {
        $projectName = projectMana::all();

        return response()->json($projectName);
    }

    public function getProjectById ($projectMana_id)
    {
        $projectMana = projectMana::find($projectMana_id);
        // $posts = auth()->user()->posts;

        return response()->json($projectMana);
    }

    public function update(Request $request, $id)
    {
        $projectMana = projectMana::find($id);
 
        if (!$projectMana) {
            return response()->json([
                'success' => false,
                'msg' => 'File not found'
            ], 400);
        }
 
        $updated = $projectMana->fill($request->all())->save();
 
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
