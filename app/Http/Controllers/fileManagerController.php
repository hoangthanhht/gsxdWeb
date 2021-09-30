<?php

namespace App\Http\Controllers;
use App\Models\pathfile;
use Illuminate\Http\Request;
use App\Models\fileManager;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\File;
use App\Traits\HelperTrait;
use App\Traits\StorageImageTrait;
class fileManagerController extends Controller
{
    use StorageImageTrait, HelperTrait;
    public function store(Request $request)
    {
        DB::beginTransaction(); 
        try{
        $arrFile = $request->file('file'); // lấy toàn bộ file là 1 mảng bên vue truyền sang
        // request()->file('file.0') như này nếu lấy 1 file trong mảng đó
        $upload = [];
        $errorFile = false;
        if ($arrFile) {

            for ($i = 0; $i < count($arrFile); $i++) {
                $array_rs = $this->uploadFile($request, 'hoso', $arrFile[$i]);
                if (is_array($array_rs) && array_key_exists('error', $array_rs)) {
                    $errorFile = true;
                }
                if (is_array($array_rs)) {
                    array_push($upload, $array_rs);

                }
                //$upload = $this->storageTraitUpload($ddd, 'congviec');
            }
        }
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
       $aliasFile = '';
        if($File->kyHieuHoSo == 'hstk'){
            $aliasFile = 'hstkFile';
        }elseif ($File->kyHieuHoSo == 'hsnt'){
            $aliasFile = 'hsntFile';
        }elseif ($File->kyHieuHoSo == 'hsk') {
            $aliasFile = 'hskFile';
        }
        foreach ($upload as $item) {
            pathfile::create([
                'idFile' => $File->id,
                'aliasTable' => $aliasFile,
                'path' => $item["file_path"],
                'rootName' => $item["file_name"],
            ]);
        }
        if ($File && $errorFile == true && $arrFile) {
            DB::commit();
            return response()->json([
                'success' => true,
                'msg' => 'Không lưu được file đính kèm',
            ]);
        } else if ($File && $errorFile == false && $arrFile) {
            DB::commit();
            return response()->json([
                'success' => true,
                'msg' => 'Tạo hồ sơ thành công',
            ]);
        } else if ($File && !$arrFile) {
            DB::commit();
            return response()->json([
                'success' => true,
                'msg' => 'Tạo hồ sơ thành công',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'msg' => 'Tạo hồ sơ không thành công',
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
        $arrLink=[];
        $fileManager = fileManager::paginate(20);
        // $posts = auth()->user()->posts;
        foreach ($fileManager as $Item) {
            if($Item->kyHieuHoSo == 'hsnt'){
                $link = DB::table('pathfiles')
                    ->where('idFile', $Item->id)
                    ->where('aliasTable', 'hsntFile')
                    ->select('path')->get();
                if (count($link) > 0) {
                    $temp = [];
                    foreach ($link as $it) {
                        array_push($temp, $this->host . $it->path);
                    }
                    array_push($arrLink, [$Item->id => $temp]);
                }
            }
            if($Item->kyHieuHoSo == 'hstk'){
                $link = DB::table('pathfiles')
                    ->where('idFile', $Item->id)
                    ->where('aliasTable', 'hstkFile')
                    ->select('path')->get();
                if (count($link) > 0) {
                    $temp = [];
                    foreach ($link as $it) {
                        array_push($temp, $this->host . $it->path);
                    }
                    array_push($arrLink, [$Item->id => $temp]);
                }
            }
            if($Item->kyHieuHoSo == 'hsk'){
                $link = DB::table('pathfiles')
                    ->where('idFile', $Item->id)
                    ->where('aliasTable', 'hskFile')
                    ->select('path')->get();
                if (count($link) > 0) {
                    $temp = [];
                    foreach ($link as $it) {
                        array_push($temp, $this->host . $it->path);
                    }
                    array_push($arrLink, [$Item->id => $temp]);
                }
            }
        }
        return response()->json(['pagi' => $fileManager,
            'link' => $arrLink,
        ], 200);
    }

    public function getAllFile()
    {
        $arrLink=[];
        $fileManager = fileManager::all();
        // $posts = auth()->user()->posts;

        foreach ($fileManager as $Item) {
            if($Item->kyHieuHoSo == 'hsnt'){
                $link = DB::table('pathfiles')
                    ->where('idFile', $Item->id)
                    ->where('aliasTable', 'hsntFile')
                    ->select('path')->get();
                if (count($link) > 0) {
                    $temp = [];
                    foreach ($link as $it) {
                        array_push($temp, $this->host . $it->path);
                    }
                    array_push($arrLink, [$Item->id => $temp]);
                }
            }
            if($Item->kyHieuHoSo == 'hstk'){
                $link = DB::table('pathfiles')
                    ->where('idFile', $Item->id)
                    ->where('aliasTable', 'hstkFile')
                    ->select('path')->get();
                if (count($link) > 0) {
                    $temp = [];
                    foreach ($link as $it) {
                        array_push($temp, $this->host . $it->path);
                    }
                    array_push($arrLink, [$Item->id => $temp]);
                }
            }
            if($Item->kyHieuHoSo == 'hsk'){
                $link = DB::table('pathfiles')
                    ->where('idFile', $Item->id)
                    ->where('aliasTable', 'hskFile')
                    ->select('path')->get();
                if (count($link) > 0) {
                    $temp = [];
                    foreach ($link as $it) {
                        array_push($temp, $this->host . $it->path);
                    }
                    array_push($arrLink, [$Item->id => $temp]);
                }
            }
        }
        return response()->json(['pagi' => $fileManager,
            'link' => $arrLink,
        ], 200);
    }

    public function getFileById ($fileManager_id)
    {
        $arrName = [];
        $arrLink = [];
        $fileManager = fileManager::find($fileManager_id);
        // $posts = auth()->user()->posts;
        if($fileManager->kyHieuHoSo == 'hsnt'){
            $link = DB::table('pathfiles')
            ->where('idFile', $fileManager_id)
            ->where('aliasTable', 'hsntFile')
            ->get();
        }
        if($fileManager->kyHieuHoSo == 'hstk'){
            $link = DB::table('pathfiles')
            ->where('idFile', $fileManager_id)
            ->where('aliasTable', 'hstkFile')
            ->get();
        }
        if($fileManager->kyHieuHoSo == 'hsk'){
            $link = DB::table('pathfiles')
            ->where('idFile', $fileManager_id)
            ->where('aliasTable', 'hskFile')
            ->get();
        }
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
    return response()->json(['pagi' => $fileManager,
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
                    $array_rs = $this->uploadFile($request, 'hoso', $arrFile[$i]);
                    if (is_array($array_rs) && array_key_exists('error', $array_rs)) {
                        $errorFile = true;
                    }
                    if (is_array($array_rs)) {
                        array_push($upload, $array_rs);

                    }
                    //$upload = $this->storageTraitUpload($ddd, 'congviec');
                }
            }
        $fileManager = fileManager::find($id);
 
        if (!$fileManager) {
            return response()->json([
                'success' => false,
                'msg' => 'File not found'
            ], 400);
        }
 
        $updated = $fileManager->fill($request->all())->save();
 
       
        $objNameRootFile = json_decode($request->arrNameFile, true);
        /* lặp qua từng key của obj chính là các id của các file dang có đê update */
        foreach ($objNameRootFile as $key => $value) {
            $file = pathfile::find($key);

            $file->rootName = $value;

            $file->save();
        }
        $aliasFile = '';
        if($fileManager->kyHieuHoSo == 'hstk'){
            $aliasFile = 'hstkFile';
        }elseif ($fileManager->kyHieuHoSo == 'hsnt'){
            $aliasFile = 'hsntFile';
        }elseif ($fileManager->kyHieuHoSo == 'hsk') {
            $aliasFile = 'hskFile';
        }
        foreach ($upload as $item) {
            pathfile::create([
                'idFile' => $id,
                'aliasTable' => $aliasFile,
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
                'msg' => 'Update hồ sơ thành công',
            ]);
        } else if ($updated && !$arrFile) {
            DB::commit();
            return response()->json([
                'success' => true,
                'msg' => 'Update hồ sơ thành công',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'msg' => 'Update hồ sơ không thành công',
            ]);
        }
        }
        catch (Exception $exception) {
            DB::rollBack();
            $this->reportException($exception);

            $response = $this->renderException($request, $exception);

        }
    }
    // xóa file thì xóa luon các file đính kèm
    public function destroy($id)
    {
        $fileManager = fileManager::find($id);
 
        if (!$fileManager) {
            return response()->json([
                'success' => false,
                'msg' => 'fileManager not found'
            ], 400);
        }
 
        if ($fileManager->delete()) {
            $linkFile = DB::table('pathfiles')
                ->where('idFile', $id)
                ->orwhere('aliasTable', 'hstkFile')
                ->orwhere('aliasTable', 'hsntFile')
                ->orwhere('aliasTable', 'hskFile')
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
                ->orwhere('aliasTable', 'hstk')
                ->orwhere('aliasTable', 'hsnt')
                ->orwhere('aliasTable', 'hsk')
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

    
}
