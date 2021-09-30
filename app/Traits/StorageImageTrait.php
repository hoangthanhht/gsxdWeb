<?php
namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
trait StorageImageTrait
{
    public function storageTraitUpload($file, $folder)
    {

        $fileNameOrigin = $file->getClientOriginalName();
        $fileNameHash = Str::random(20) . '.' . $file->getClientOriginalExtension();
        $filePath = $file->storeAs('public/' . $folder, $fileNameHash);
        $dataUploadTrait = [
            'file_name' => $fileNameOrigin,
            'file_path' => Storage::url($filePath),
        ];
        return $dataUploadTrait;
    }

    public function storageTraitUploadMultiple($file, $folderName)
    {

        $fileNameOrigin = $file->getClientOriginalName();
        $fileNameHash = Str::random(20) . '.' . $file->getClientOriginalExtension();
        $fliePath = $file->storeAs('public/' . $folderName . '/' . auth()->id(), $fileNameHash);
        $dataUploadTrait = [
            'file_name' => $fileNameOrigin,
            'file_path' => Storage::url($fliePath),
        ];
        return $dataUploadTrait;

        return null;
    }

    public function uploadFile(Request $request,$folder,$file)
    {
        $validator = Validator::make($request->all(), [
            'file.*' => 'required|mimes:jpg,png,jpeg,xlsx,pdf,doc,docx,xls,xlsm,dwg,bmp|max:4096',// phải có .* khi validate cho cả 1 mảng cấc file phần đuôi mở rộng
            // nếu chỉ có 1 file thì không có .*
        ]);

        if ($validator->fails()) {

            return response()->json(['error' => $validator->errors()], 401);
        }

        if ($file) {

                $dataUploadTrait = $this->storageTraitUpload($file, $folder);
                return $dataUploadTrait;
        }

    }

    public function getPathFile($instanceModel) {
        $urlAvartar = url($instanceModel->path_avatar);
        return $urlAvartar;
    }
}
