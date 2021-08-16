<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\position;
class positionController extends Controller
{
    public function store(Request $request)
    {
        $position = position::create([
            //$ArticlePost = DB::table('article_posts')->insert([
                'chucDanh'=>$request->chucDanh,
                'ghiChu'=>$request->ghiChu,
                'maChucDanh'=>$request->maChucDanh,
         
        ]);
        if($position) {
            return response()->json([
                'success' => true,
                'msg' => 'Tạo chức danh thành công',
            ]);
        }else{
            return response()->json([
                'success' => false,
                'msg' => 'Tạo chức danh không thành công',
            ]);
        }
    }

    public function show ()
    {
        $position = position::paginate(20);
        // $posts = auth()->user()->posts;

        return response()->json($position);
    }

    public function getPositionById ($position_id)
    {
        $position = position::find($position_id);
        // $posts = auth()->user()->posts;

        return response()->json($position);
    }

    public function update(Request $request, $id)
    {
        $position = position::find($id);
 
        if (!$position) {
            return response()->json([
                'success' => false,
                'msg' => 'File not found'
            ], 400);
        }
 
        $updated = $position->fill($request->all())->save();
 
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
        $position = position::find($id);
 
        if (!$position) {
            return response()->json([
                'success' => false,
                'msg' => 'Position not found'
            ], 400);
        }
 
        if ($position->delete()) {
            return response()->json([
                'success' => true,
                'msg' => 'Xóa thành công'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'msg' => 'Position can not be deleted'
            ], 500);
        }
    }
}
