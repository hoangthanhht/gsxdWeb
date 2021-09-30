<?php

namespace App\Http\Controllers;

use App\Models\pathfile;
use App\Traits\HelperTrait;
use App\Traits\StorageImageTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Models\projectMana;
class projectController extends Controller
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
                    $array_rs = $this->uploadFile($request, 'project', $arrFile[$i]);
                    if (is_array($array_rs) && array_key_exists('error', $array_rs)) {
                        $errorFile = true;
                    }
                    if (is_array($array_rs)) {
                        array_push($upload, $array_rs);

                    }
                    //$upload = $this->storageTraitUpload($ddd, 'congviec');
                }
            }
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
        foreach ($upload as $item) {
            pathfile::create([
                'idFile' => $projectMana->id,
                'aliasTable' => 'project',
                'path' => $item["file_path"],
                'rootName' => $item["file_name"],
            ]);
        }
        if ($projectMana && $errorFile == true && $arrFile) {
            DB::commit();
            return response()->json([
                'success' => true,
                'msg' => 'Không lưu được file đính kèm',
            ]);
        } else if ($projectMana && $errorFile == false && $arrFile) {
            DB::commit();
            return response()->json([
                'success' => true,
                'msg' => 'Tạo dự án thành công',
            ]);
        } else if ($projectMana && !$arrFile) {
            DB::commit();
            return response()->json([
                'success' => true,
                'msg' => 'Tạo dự án thành công',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'msg' => 'Tạo dự án không thành công',
            ]);
        }
    } catch (Exception $exception) {
        DB::rollBack();
        $this->reportException($exception);

        $response = $this->renderException($request, $exception);

    }
    }

    public function show ()
    {
        $arrLink = [];
        $projectMana = projectMana::paginate(20);
        foreach ($projectMana as $Item) {
            $link = DB::table('pathfiles')
                ->where('idFile', $Item->id)
                ->where('aliasTable', 'project')
                ->select('path')->get();
            if (count($link) > 0) {
                $temp = [];
                foreach ($link as $it) {
                    array_push($temp,  $this->host. $it->path);
                }
                array_push($arrLink, [$Item->id => $temp]);
            }
        }
        return response()->json(['pagi' => $projectMana,
            'link' => $arrLink,
        ], 200);
    }

    public function getAllProjectMana()
    {
        $arrLink = [];
        $projectMana = projectMana::all();
        foreach ($projectMana as $Item) {
            $link = DB::table('pathfiles')
                ->where('idFile', $Item->id)
                ->where('aliasTable', 'project')
                ->select('path')->get();
            if (count($link) > 0) {
                $temp = [];
                foreach ($link as $it) {
                    array_push($temp, $this->host . $it->path);
                }
                array_push($arrLink, [$Item->id => $temp]);
            }
        }
        return response()->json(['pagi' => $projectMana,
            'link' => $arrLink,
        ], 200);
    }

    public function getProjectName ()
    {
        $projectName = projectMana::all();

        return response()->json($projectName);
    }

    public function getProjectById ($projectMana_id)
    {
        $arrName = [];
        $arrLink = [];
        $projectMana = projectMana::find($projectMana_id);
        $link = DB::table('pathfiles')
        ->where('idFile', $projectMana_id)
        ->where('aliasTable', 'project')
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
            return response()->json(['pagi' => $projectMana,
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
                    $array_rs = $this->uploadFile($request, 'project', $arrFile[$i]);
                    if (is_array($array_rs) && array_key_exists('error', $array_rs)) {
                        $errorFile = true;
                    }
                    if (is_array($array_rs)) {
                        array_push($upload, $array_rs);

                    }
                    //$upload = $this->storageTraitUpload($ddd, 'congviec');
                }
            }
        $projectMana = projectMana::find($id);
 
        if (!$projectMana) {
            return response()->json([
                'success' => false,
                'msg' => 'File not found'
            ], 400);
        }
 
        $updated = $projectMana->fill($request->all())->save();
 
        $objNameRootFile = json_decode($request->arrNameFile, true);
        foreach ($objNameRootFile as $key => $value) {
            $file = pathfile::find($key);

            $file->rootName = $value;

            $file->save();
        }
        foreach ($upload as $item) {
            pathfile::create([
                'idFile' => $id,
                'aliasTable' => 'project',
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
        $projectMana = projectMana::find($id);
 
        if (!$projectMana) {
            return response()->json([
                'success' => false,
                'msg' => 'projectMana not found'
            ], 400);
        }
 
        if ($projectMana->delete()) {
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
                'msg' => 'Xóa thành công'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'msg' => 'projectMana can not be deleted'
            ], 500);
        }
    }
}
