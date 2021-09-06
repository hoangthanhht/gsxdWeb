<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\infomationEmploy;
class infomationEmployController extends Controller
{
    public function store(Request $request)
    {
        $infomationEmploy = infomationEmploy::create([
            //$ArticlePost = DB::table('article_posts')->insert([
                'codeEmploy'=>$request->codeEmploy,
                'userNameEmploy'=>$request->userNameEmploy,
                'nameEmploy'=>$request->nameEmploy,
                'teleEmploy'=>$request->teleEmploy,
                'emailEmploy'=>$request->emailEmploy,
                'genderEmploy'=>$request->genderEmploy,
                'birthdayEmploy'=>$request->birthdayEmploy,
                'placeOfBirthEmploy'=>$request->placeOfBirthEmploy,
                'homeTownEmploy'=>$request->homeTownEmploy,
                'permanentResidenceEmploy'=>$request->permanentResidenceEmploy,
                'currentAccommodationEmploy'=>$request->currentAccommodationEmploy,
                'majorsEmploy'=>$request->majorsEmploy,
                'trainingPlacesEmploy'=>$request->trainingPlacesEmploy,
                'nationEmploy'=>$request->nationEmploy,
                'religionEmploy'=>$request->religionEmploy,
                'qualificationEmploy'=>$request->qualificationEmploy,
                'graduationYearEmploy'=>$request->graduationYearEmploy,
                'IDCardEmploy'=>$request->IDCardEmploy,
                'dateRangeEmploy'=>$request->dateRangeEmploy,
                'issuedByEmploy'=>$request->issuedByEmploy,
                'accountNumberEmploy'=>$request->accountNumberEmploy,
                'bankEmploy'=>$request->bankEmploy,
                'branchBankEmploy'=>$request->branchBankEmploy,
                'practicingCertificateTVGS'=>$request->practicingCertificateTVGS,
                'practicingCertificateTVGSEffectiveDate'=>$request->practicingCertificateTVGSEffectiveDate,
                'practicingCertificateATLD'=>$request->practicingCertificateATLD,
                'practicingCertificateTVTK'=>$request->practicingCertificateTVTK,
                'practicingCertificateOther'=>$request->practicingCertificateOther,
                'DateOfReceivingTheJob'=>$request->DateOfReceivingTheJob,
                'Department'=>$request->Department,
                'Position'=>$request->Position,
                'socialInsurance'=>$request->socialInsurance,
                'typeOfContract'=>$request->typeOfContract,
                'workStatus'=>$request->workStatus,
                'socialInsuranceNumber'=>$request->socialInsuranceNumber,
                'dayOff'=>$request->dayOff,
                'socialInsurancePremium'=>$request->socialInsurancePremium,
                'descriptionEmploy'=>$request->descriptionEmploy,
        ]);
        if($infomationEmploy) {
            return response()->json([
                'success' => true,
                'msg' => 'Tạo thông tin nhân viên thành công',
            ]);
        }else{
            return response()->json([
                'success' => false,
                'msg' => 'Tạo thông tin nhân viên không thành công',
            ]);
        }
    }

    public function show ()
    {
        $infomationEmploy = infomationEmploy::paginate(20);
        // $posts = auth()->user()->posts;

        return response()->json($infomationEmploy);
    }

    public function getAllInfomationEmploy ()
    {
        $infomationEmploy = infomationEmploy::all();
        // $posts = auth()->user()->posts;

        return response()->json($infomationEmploy);
    }

    public function getInfomationEmployById ($infomationEmploy_id)
    {
        $infomationEmploy = infomationEmploy::find($infomationEmploy_id);
        // $posts = auth()->user()->posts;

        return response()->json($infomationEmploy);
    }

    public function getInfomationEmployByAcount ($acount)
    {
        $infomationEmploy = infomationEmploy::where('userNameEmploy', $acount)
  
        ->first();
        // $posts = auth()->user()->posts;

        return response()->json($infomationEmploy);
    }

    public function update(Request $request, $id)
    {
        $infomationEmploy = infomationEmploy::find($id);
 
        if (!$infomationEmploy) {
            return response()->json([
                'success' => false,
                'msg' => 'File not found'
            ], 400);
        }
 
        $updated = $infomationEmploy->fill($request->all())->save();
 
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
        $infomationEmploy = infomationEmploy::find($id);
 
        if (!$infomationEmploy) {
            return response()->json([
                'success' => false,
                'msg' => 'infomationEmploy not found'
            ], 400);
        }
 
        if ($infomationEmploy->delete()) {
            return response()->json([
                'success' => true,
                'msg' => 'Xóa thành công'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'msg' => 'infomationEmploy can not be deleted'
            ], 500);
        }
    }
}
