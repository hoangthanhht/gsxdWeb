<?php

namespace App\Http\Controllers;

use App\Models\pathfile;
use App\Models\task;
use App\Traits\HelperTrait;
use App\Traits\StorageImageTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class taskController extends Controller
{
    use StorageImageTrait, HelperTrait;
    public function store(Request $request)
    {
        DB::beginTransaction(); // đảm bảo tính toàn vẹn dữ liệu
        try {
            $arrFile = $request->file('file'); // lấy toàn bộ file là 1 mảng bên vue truyền sang
            // request()->file('file.0') như này nếu lấy 1 file trong mảng đó
            $upload = [];
            $errorFile = false;
            if ($arrFile) {

                for ($i = 0; $i < count($arrFile); $i++) {
                    $array_rs = $this->uploadFile($request, 'congviec', $arrFile[$i]);
                    if (is_array($array_rs) && array_key_exists('error', $array_rs)) {
                        $errorFile = true;
                    }
                    if (is_array($array_rs)) {
                        array_push($upload, $array_rs);

                    }
                    //$upload = $this->storageTraitUpload($ddd, 'congviec');
                }
            }
            $Task = task::create([
                //$ArticlePost = DB::table('article_posts')->insert([
                'Ten' => $request->Ten,
                'keHoach' => $request->keHoach,
                'thucHien' => $request->thucHien,
                'nguoiDeXuat' => $request->nguoiDeXuat,
                'nguoiPhoiHop' => $request->nguoiPhoiHop,
                'moTaTask' => $request->moTaTask,
                'mucDo' => $request->mucDo,
                'ketQua' => $request->ketQua,
                'tinhTrang' => $request->tinhTrang,
                'luuY' => $request->luuY,
                'duanLienQuan' => $request->duanLienQuan,
            ]);

            foreach ($upload as $item) {
                pathfile::create([
                    'idFile' => $Task->id,
                    'aliasTable' => 'Task',
                    'path' => $item["file_path"],
                    'rootName' => $item["file_name"],
                ]);
            }
            if ($Task && $errorFile == true && $arrFile) {
                DB::commit();
                return response()->json([
                    'success' => true,
                    'msg' => 'Không lưu được file đính kèm',
                ]);
            } else if ($Task && $errorFile == false && $arrFile) {
                DB::commit();
                return response()->json([
                    'success' => true,
                    'msg' => 'Tạo công việc thành công',
                ]);
            } else if ($Task && !$arrFile) {
                DB::commit();
                return response()->json([
                    'success' => true,
                    'msg' => 'Tạo công việc thành công',
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'msg' => 'Tạo công việc không thành công',
                ]);
            }
        } catch (Exception $exception) {
            DB::rollBack();
            $this->reportException($exception);

            $response = $this->renderException($request, $exception);

        }
    }

    public function show()
    {
        $arrLink = [];
        $task = task::paginate(20);
        // $posts = auth()->user()->posts;
        foreach ($task as $Item) {
            $link = DB::table('pathfiles')
                ->where('idFile', $Item->id)
                ->where('aliasTable', 'Task')
                ->select('path')->get();
            if (count($link) > 0) {
                $temp = [];
                foreach ($link as $it) {
                    array_push($temp, $this->host . $it->path);
                }
                array_push($arrLink, [$Item->id => $temp]);
            }
        }
        return response()->json(['pagi' => $task,
            'link' => $arrLink,
        ], 200);
    }

    public function getAllTask()
    {
        $arrLink = [];
        $task = task::all();
        // $posts = auth()->user()->posts;
        foreach ($task as $Item) {
            $link = DB::table('pathfiles')
                ->where('idFile', $Item->id)
                ->where('aliasTable', 'Task')
                ->select('path')->get();
            if (count($link) > 0) {
                $temp = [];
                foreach ($link as $it) {
                    array_push($temp, $this->host . $it->path);
                }
                array_push($arrLink, [$Item->id => $temp]);
            }
        }
        return response()->json(['pagi' => $task,
            'link' => $arrLink,
        ], 200);
    }

    public function getTaskById($task_id)
    {
        $arrName = [];
        $arrLink = [];
        $task = task::find($task_id);
        // $posts = auth()->user()->posts;
        $link = DB::table('pathfiles')
            ->where('idFile', $task_id)
            ->where('aliasTable', 'Task')
            ->get();
        if (count($link) > 0) {
            foreach ($link as $it) {
                array_push($arrName, $it->rootName);
            }

        }
        if (count($link) > 0) {
            foreach ($link as $it) {
                array_push($arrLink, $this->host . $it->path);
            }
        }
        return response()->json(['pagi' => $task,
            'item' => $link,
        ], 200);
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction(); // đảm bảo tính toàn vẹn dữ liệu
        try {
            $arrFile = $request->file('file'); // lấy toàn bộ file là 1 mảng bên vue truyền sang
            // request()->file('file.0') như này nếu lấy 1 file trong mảng đó
            $upload = [];
            $errorFile = false;
            if ($arrFile) {

                for ($i = 0; $i < count($arrFile); $i++) {
                    $array_rs = $this->uploadFile($request, 'congviec', $arrFile[$i]);
                    if (is_array($array_rs) && array_key_exists('error', $array_rs)) {
                        $errorFile = true;
                    }
                    if (is_array($array_rs)) {
                        array_push($upload, $array_rs);

                    }
                    //$upload = $this->storageTraitUpload($ddd, 'congviec');
                }
            }
            $task = task::find($id);

            if (!$task) {
                return response()->json([
                    'success' => false,
                    'msg' => 'Task not found',
                ], 400);
            }

            $updated = $task->fill($request->all())->save();

            $objNameRootFile = json_decode($request->arrNameFile, true);
            foreach ($objNameRootFile as $key => $value) {
                $file = pathfile::find($key);

                $file->rootName = $value;

                $file->save();
            }
            foreach ($upload as $item) {
                pathfile::create([
                    'idFile' => $id,
                    'aliasTable' => 'Task',
                    'path' => $item["file_path"],
                    'rootName' => $item["file_name"],
                ]);
            }
            if ($updated && $errorFile == true && $arrFile) {
                DB::commit();
                return response()->json([
                    'success' => true,
                    'msg' => 'Không lưu được file đính kèm',
                ]);
            } else if ($updated && $errorFile == false && $arrFile) {
                DB::commit();
                return response()->json([
                    'success' => true,
                    'msg' => 'Update công việc thành công',
                ]);
            } else if ($updated && !$arrFile) {
                DB::commit();
                return response()->json([
                    'success' => true,
                    'msg' => 'Update công việc thành công',
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'msg' => 'Update công việc không thành công',
                ]);
            }
        } catch (Exception $exception) {
            DB::rollBack();
            $this->reportException($exception);

            $response = $this->renderException($request, $exception);

        }
    }

    public function destroy($id)
    {
        $task = task::find($id);

        if (!$task) {
            return response()->json([
                'success' => false,
                'msg' => 'task not found',
            ], 400);
        }

        if ($task->delete()) {
            $linkFile = DB::table('pathfiles')
                ->where('idFile', $id)
                ->where('aliasTable', 'Task')
                ->get();
            foreach ($linkFile as $it) {

                $filePath = ($it->path);
                $nameHashFile = substr($filePath, 1, strlen($filePath) - 1);
                if (File::exists($nameHashFile)) {
                    File::delete($nameHashFile);
                }

            }
            $linkFile = DB::table('pathfiles')
                ->where('idFile', $id)
                ->where('aliasTable', 'Task')
                ->delete();
            return response()->json([
                'success' => true,
                'msg' => 'Xóa thành công',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'msg' => 'task can not be deleted',
            ], 500);
        }
    }

    public function destroyFileAttach($id)
    {
        $FileAttach = pathfile::find($id);

        if (!$FileAttach) {
            return response()->json([
                'success' => false,
                'msg' => 'file not found',
            ], 400);
        }

        if ($FileAttach->delete()) {
            $filePath = ($FileAttach->path);
            $nameHashFile = substr($filePath, 1, strlen($filePath) - 1);
            if (File::exists($nameHashFile)) {
                File::delete($nameHashFile);
            }
            return response()->json([
                'success' => true,
                'msg' => 'Xóa thành công',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'msg' => 'file can not be deleted',
            ], 500);
        }
    }
}
