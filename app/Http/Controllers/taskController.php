<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\task;

class taskController extends Controller
{
    public function store(Request $request)
    {
        $Task = task::create([
            //$ArticlePost = DB::table('article_posts')->insert([
                'Ten'=>$request->Ten,
                'keHoach'=>$request->keHoach,
                'thucHien'=>$request->thucHien,
                'nguoiDeXuat'=>$request->nguoiDeXuat,
                'nguoiPhoiHop'=>$request->nguoiPhoiHop,
                'moTaTask'=>$request->moTaTask,
                'mucDo'=>$request->mucDo,
                'ketQua'=>$request->ketQua,
                'tinhTrang'=>$request->tinhTrang,
                'luuY'=>$request->luuY,
        ]);
        if($Task) {
            return response()->json([
                'success' => true,
                'msg' => 'Tạo công việc thành công',
            ]);
        }else{
            return response()->json([
                'success' => false,
                'msg' => 'Tạo công việc không thành công',
            ]);
        }
    }

    public function show ()
    {
        $task = task::paginate(20);
        // $posts = auth()->user()->posts;

        return response()->json($task);
    }
}
