<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\ReportDay;
use App\Models\User;
use Illuminate\Support\Facades\DB;
class ReportDayController extends Controller
{
    public function index()
    {
        $posts = ReportDay::all(); // hàm all sẽ lất ra tất cả sản phẩm
        // $posts = auth()->user()->posts;
  
        return response()->json([
            'success' => true,
            'data' => $posts
        ]);
    }
 
    public function show($time)
    {
        //$post = auth()->user()->posts()->find($id);
        $time = str_replace('-','/',$time);
        $post = DB::table('report_days')
        ->where('dateBaocao', $time)
        ->get();
        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found '
            ], 400);
        }
 
        return response()->json([
            'success' => true,
            'data' => $post->toArray()
        ], 200);
    }
 
    public function store(Request $request)
    {
        $this->validate($request, [
            'contentJson' => 'required',
            'dateBaocao' => 'required',
            'loaiBaocao' => 'required',
            
        ]);
        $post = new ReportDay();
        $post->contentJson = $request->contentJson;
        $post->dateBaocao = $request->dateBaocao;
        $post->imgBase64 = $request->imgBase64;
        $post->loaiBaocao = $request->loaiBaocao;
        $post->user_id = $request->user_id;
        $post->tenDuan = $request->tenDuan;
        $post->diaDiem = $request->diaDiem;
        $post->chuDauTu = $request->chuDauTu;
        $post->banQuanLy = $request->banQuanLy;
        $post->nhaThau = $request->nhaThau;
        $post->tvtk = $request->tvtk;
        //return ReportDay::create($request->all());
        if (auth()->user()->posts()->save($post))
            return response()->json([
                'success' => true,
                'data' => $post->toArray()
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Post not added'
            ], 500);
    }
 
    public function update(Request $request, $id)
    {
        $post = auth()->user()->posts()->find($id);
 
        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found'
            ], 400);
        }
 
        $updated = $post->fill($request->all())->save();
 
        if ($updated)
            return response()->json([
                'success' => true,
                'message' => 'Update thành công'
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Post can not be updated'
            ], 500);
    }
 
    public function destroy($id)
    {
        $post = auth()->user()->posts()->find($id);
 
        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found'
            ], 400);
        }
 
        if ($post->delete()) {
            return response()->json([
                'success' => true,
                'message' => 'Xóa thành công'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Post can not be deleted'
            ], 500);
        }
    }

    public function getTimeBaoCao(Request $request)
    {
        $post = null;
        if($request->kind === 'D')
        //$posts = ReportDay::all(); // hàm all sẽ lất ra tất cả sản phẩm
        // $posts = auth()->user()->posts;
        {
            $post = DB::table('report_days')
            ->where('loaiBaocao', 'D')
            ->where('tenDuan', $request->site)
            ->select('dateBaocao')->distinct()->get();
         
        }
        if($request->kind === 'W')
        {
            $post = DB::table('report_days')
            ->where('loaiBaocao', 'W')
            ->where('tenDuan', $request->site)
            ->select('dateBaocao')->distinct()->get();
        }
        if($request->kind === 'M')
        {
            $post = DB::table('report_days')
            ->where('loaiBaocao', 'M')
            ->where('tenDuan', $request->site)
            ->select('dateBaocao')->distinct()->get();
        }
        if($post)
        {
            return response()->json([
                'success' => true,
                'data' => $post
            ],200);
        }
    }

    public function getNameProject(Request $request)
    {
        $getNameProject = DB::table('report_days')
        ->where('loaiBaocao',$request->kind)
        ->select('tenDuan')->distinct()->get();
        if($getNameProject)
        {
            return response()->json([
                'success' => true,
                'data' => $getNameProject
            ],200);
        }
    }

    public function getContentBaoCao($time,$nameProj)
    {
        //$post = auth()->user()->posts()->find($id);
        $time = str_replace('_','/',$time);
        $post = DB::table('report_days')
        ->where('dateBaocao', $time)
        ->where('tenDuan', $nameProj)
        ->get();
        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found '
            ], 400);
        }
 
        return response()->json([
            'success' => true,
            'data' => $post->toArray()
        ], 200);
    }

    public function deleteBaoCao($time,$nameProj)
    {
        //$post = auth()->user()->posts()->find($id);
        $post = DB::table('report_days')
        ->where('dateBaocao', $time)
        ->where('tenDuan', $nameProj)
        ->delete();
        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Xóa báo cáo không thành công'
            ], 400);
        }
 
        return response()->json([
            'success' => true,
            'message' => 'Xóa báo cáo thành công'
        ], 200);
    }
 
}