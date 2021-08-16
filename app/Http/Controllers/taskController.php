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
                'duanLienQuan'=>$request->duanLienQuan,
                
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
    public function getTaskById ($task_id)
    {
        $task = task::find($task_id);
        // $posts = auth()->user()->posts;

        return response()->json($task);
    }

    public function update(Request $request, $id)
    {
        $task = task::find($id);
 
        if (!$task) {
            return response()->json([
                'success' => false,
                'msg' => 'Task not found'
            ], 400);
        }
 
        $updated = $task->fill($request->all())->save();
 
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
    public function destroy($id)
    {
        $task = task::find($id);
 
        if (!$task) {
            return response()->json([
                'success' => false,
                'msg' => 'task not found'
            ], 400);
        }
 
        if ($task->delete()) {
            return response()->json([
                'success' => true,
                'msg' => 'Xóa thành công'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'msg' => 'task can not be deleted'
            ], 500);
        }
    }
}
