<?php

namespace App\Http\Controllers;
use App\Traits\HelperTrait;
use App\Traits\StorageImageTrait;
use Exception;
use App\Models\pathfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\contract;
use Illuminate\Support\Facades\File;
class contractController extends Controller
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
                    $array_rs = $this->uploadFile($request, 'hopdong', $arrFile[$i]);
                    if (is_array($array_rs) && array_key_exists('error', $array_rs)) {
                        $errorFile = true;
                    }
                    if (is_array($array_rs)) {
                        array_push($upload, $array_rs);

                    }
                    //$upload = $this->storageTraitUpload($ddd, 'congviec');
                }
            }
        $contract = contract::create([
            //$ArticlePost = DB::table('article_posts')->insert([
                'tenHopDong'=>$request->tenHopDong,
                'loaiHopDong'=>$request->loaiHopDong,
                'duAn'=>$request->duAn,
                'giaTriHD'=>$request->giaTriHD,
                'nhanSuLienQuan'=>$request->nhanSuLienQuan,
                'batDau'=>$request->batDau,
                'ketThuc'=>$request->ketThuc,
                'donVi'=>$request->donVi,
                'khoiLuong'=>$request->khoiLuong,
        ]);
        foreach ($upload as $item) {
            pathfile::create([
                'idFile' => $contract->id,
                'aliasTable' => 'contract',
                'path' => $item["file_path"],
                'rootName' => $item["file_name"],
            ]);
        }
        if ($contract && $errorFile == true && $arrFile) {
            DB::commit();
            return response()->json([
                'success' => true,
                'msg' => 'Không lưu được file đính kèm',
            ]);
        } else if ($contract && $errorFile == false && $arrFile) {
            DB::commit();
            return response()->json([
                'success' => true,
                'msg' => 'Tạo công việc thành công',
            ]);
        } else if ($contract && !$arrFile) {
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

    public function show ()
    {
        $arrLink = [];
        $contract = contract::paginate(20);
        // $posts = auth()->user()->posts;

        foreach ($contract as $Item) {
            $link = DB::table('pathfiles')
                ->where('idFile', $Item->id)
                ->where('aliasTable', 'contract')
                ->select('path')->get();
            if (count($link) > 0) {
                $temp = [];
                foreach ($link as $it) {
                    array_push($temp, $this->host . $it->path);
                }
                array_push($arrLink, [$Item->id => $temp]);
            }
        }
        return response()->json(['pagi' => $contract,
            'link' => $arrLink,
        ], 200);
    }


    public function getAllContract ()
    {
        $arrLink = [];
        $contract = contract::all();
        foreach ($contract as $Item) {
            $link = DB::table('pathfiles')
                ->where('idFile', $Item->id)
                ->where('aliasTable', 'contract')
                ->select('path')->get();
            if (count($link) > 0) {
                $temp = [];
                foreach ($link as $it) {
                    array_push($temp, $this->host . $it->path);
                }
                array_push($arrLink, [$Item->id => $temp]);
            }
        }
        return response()->json(['pagi' => $contract,
            'link' => $arrLink,
        ], 200);
    }

    public function getContractById ($contract_id)
    {
        $arrName = [];
        $arrLink = [];
        $contract = contract::find($contract_id);
        $link = DB::table('pathfiles')
            ->where('idFile', $contract_id)
            ->where('aliasTable', 'contract')
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
        return response()->json(['pagi' => $contract,
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
                    $array_rs = $this->uploadFile($request, 'hopdong', $arrFile[$i]);
                    if (is_array($array_rs) && array_key_exists('error', $array_rs)) {
                        $errorFile = true;
                    }
                    if (is_array($array_rs)) {
                        array_push($upload, $array_rs);

                    }
                    //$upload = $this->storageTraitUpload($ddd, 'congviec');
                }
            }
        $contract = contract::find($id);
 
        if (!$contract) {
            return response()->json([
                'success' => false,
                'msg' => 'File not found'
            ], 400);
        }
 
        $updated = $contract->fill($request->all())->save();
 
        $objNameRootFile = json_decode($request->arrNameFile, true);
        foreach ($objNameRootFile as $key => $value) {
            $file = pathfile::find($key);

            $file->rootName = $value;

            $file->save();
        }
        foreach ($upload as $item) {
            pathfile::create([
                'idFile' => $id,
                'aliasTable' => 'contract',
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
        $contract = contract::find($id);
 
        if (!$contract) {
            return response()->json([
                'success' => false,
                'msg' => 'contract not found'
            ], 400);
        }
 
        if ($contract->delete()) {
            $linkFile = DB::table('pathfiles')
            ->where('idFile', $id)
            ->where('aliasTable', 'contract')
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
                'msg' => 'contract can not be deleted'
            ], 500);
        }
    }
}
