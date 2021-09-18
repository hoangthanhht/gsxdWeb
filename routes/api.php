<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PassportAuthController;
use App\Http\Controllers\ReportDayController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminRoleController;
use App\Http\Controllers\VerifyEmailController;
use App\Http\Controllers\AdminConfigSystem;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\taskController;
use App\Http\Controllers\fileManagerController;
use App\Http\Controllers\contractController;
use App\Http\Controllers\projectController;
use App\Http\Controllers\infomationEmployController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\positionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', [PassportAuthController::class, 'register']);
Route::post('login', [PassportAuthController::class, 'login']);

Route::group(['middleware' => 'auth:api'], function(){
    
    // đổi mật khẩu cho nguoi dung khi da dang nhap
    Route::post('changePassAfterLogin', [ResetPasswordController:: class,'changePass']);
    // upload avatar và lưu vao database
    Route::post('upload', [PassportAuthController::class, 'upload']);
    Route::get('details', [PassportAuthController::class, 'details']);
    // route này sẽ gửi lại link xác minh
    Route::post('/email/verification-notification', [VerifyEmailController::class, 'resendNotification'])
    ->name('verification.send');
    });

// route này sẽ hiện ra khi người dùng click vào link xác minh
Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, 'verify'])
    ->middleware(['signed'])->name('verification.verify');
//api gửi báo cáo ngày tư vấn giam sát
Route::middleware('auth:api')->group(function () {
    Route::resource('post/bcday', ReportDayController::class);
});
// láy toàn bộ các bản ghi theo 1 thời gian cụ thể
Route::post('getTimeBaoCao', [ReportDayController::class, 'getTimeBaoCao']);
// láy toàn bộ các du an dang giam sat
Route::post('getNameProject', [ReportDayController::class, 'getNameProject']);
// láy toàn bộ các du an dang giam sat
Route::get('getContentBaoCao/{time}/{nameProj}', [ReportDayController::class, 'getContentBaoCao']);

//=======================================\\//================================//
/* PHẦN API CHO USER */
// lấy dữ liệu user và role về từ data base
Route::get('getDataTableUser', [AdminUserController::class, 'index']);
// lấy dữ liệu role về từ data base
Route::get('getDataTableRole', [AdminRoleController::class, 'index']);
// tao user va role
Route::post('createUser', [AdminUserController::class, 'store']);
// edit user va role
Route::post('updateUser/{id}', [AdminUserController::class, 'update']);
// delete user va role
Route::post('deleteUser/{id}', [AdminUserController::class, 'delete']);
// edit role
Route::post('updateRole/{id}', [AdminRoleController::class, 'update']);
// delete role
Route::post('deleteRole/{id}', [AdminRoleController::class, 'delete']);
// tao role
Route::post('createRole', [AdminRoleController::class, 'store']);
// thay doi file env
Route::post('changeEnvironment', [AdminConfigSystem::class, 'changeEnvironment']);
// bảo trì hệ thống
Route::post('offSystem', [AdminConfigSystem::class, 'offSystem']);
// mở lại hệ thống
Route::post('onSystem', [AdminConfigSystem::class, 'onSystem']);
// gửi email reset pass
Route::post('sendEmailResetPassword', [ResetPasswordController:: class,'sendMail']);
// đổi mật khẩu
Route::post('changePass', [ResetPasswordController:: class,'reset']);
// lấy đường dãn file avatar
Route::get('getPathFile/{id}', [PassportAuthController::class, 'getPathFile']);
//====================================\\//====================================//


/* API CHO CÔNG VIỆC */
// tạo công việc
Route::post('createTask', [taskController:: class,'store']);
// lấy công việc 
Route::get('showTask', [taskController::class, 'show']);
// lấy công việc 
Route::get('getTaskById/{id}', [taskController::class, 'getTaskById']);
// update công việc 
Route::post('updateTask/{id}', [taskController::class, 'update']);
// xoa tin công việc
Route::post('destroyTask/{id}', [taskController::class, 'destroy']);
//get all công việc
Route::get('getAllTask', [taskController::class, 'getAllTask']);

//====================================\\//====================================//
/* API CHO HỒ SƠ */
// tạo hồ sơ
Route::post('createFile', [fileManagerController:: class,'store']);
// lấy thông tin hồ sơ
Route::get('showFile', [fileManagerController::class, 'show']);
// lấy công việc 
Route::get('getFileById/{id}', [fileManagerController::class, 'getFileById']);
// update ho so
Route::post('updateFile/{id}', [fileManagerController::class, 'update']);
// xoa tin  ho so
Route::post('destroyFile/{id}', [fileManagerController::class, 'destroy']);
//get all ho so
Route::get('getAllFile', [fileManagerController::class, 'getAllFile']);
//=======================================\\//==================================//

/* API CHO HOP DỒNG */
// tạo hợp đồng
Route::post('createContract', [contractController:: class,'store']);
// lấy thông tin hợp đồng
Route::get('showContract', [contractController::class, 'show']);
// lấy hợp đồng 
Route::get('getContractById/{id}', [contractController::class, 'getContractById']);
// update hợp đồng
Route::post('updateContract/{id}', [contractController::class, 'update']);
// xoa tin hợp đồng
Route::post('destroyContract/{id}', [contractController::class, 'destroy']);
//get all hợp đồng
Route::get('getAllContract', [contractController::class, 'getAllContract']);


//=======================================\\//==================================//

/* API CHO PROJECT */
// tạo project
Route::post('createProject', [projectController:: class,'store']);
// lấy thông tin project
Route::get('showProject', [projectController::class, 'show']);
// lấy ten project
Route::get('getProjectName', [projectController::class, 'getProjectName']);
// lấy tin project 
Route::get('getProjectById/{id}', [projectController::class, 'getProjectById']);
// update tin project
Route::post('updateProject/{id}', [projectController::class, 'update']);
// xoa tin project
Route::post('destroyProject/{id}', [projectController::class, 'destroy']);
//get all project
Route::get('getAllProjectMana', [projectController::class, 'getAllProjectMana']);

//=======================================\\//==================================//

/* API CHO INFOMATION EMPLOY*/
// tạo infomation Employ
Route::post('createinfomationEmploy', [infomationEmployController:: class,'store']);
// lấy infomation Employ
Route::get('showinfomationEmploy', [infomationEmployController::class, 'show']);
// lấy infomation Employ 
Route::get('getInfomationEmployById/{id}', [infomationEmployController::class, 'getInfomationEmployById']);
// lấy infomation Employ 
Route::get('getInfomationEmployByAcount/{ac}', [infomationEmployController::class, 'getInfomationEmployByAcount']);
// lấy infomation Employ 
Route::get('getAllInfomationEmploy', [infomationEmployController::class, 'getAllInfomationEmploy']);

// update infomation Employ
Route::post('updateInfomationEmploy/{id}', [infomationEmployController::class, 'update']);
// xoa tin infomation Employ
Route::post('destroyInfomationEmploy/{id}', [infomationEmployController::class, 'destroy']);
//=======================================\\//==========================================================//
/* API CHO BACKUP DU LIEU */
Route::get('getListFile', [BackupController::class, 'index']);
Route::get('downLoadFile/{id}', [BackupController::class, 'download']);
Route::get('deleteFile/{id}', [BackupController::class, 'destroy']);

//=======================================\\//==================================//
/* API CHO POSITION */
// tạo Position
Route::post('createPosition', [positionController:: class,'store']);
// lấy thông tin Position
Route::get('showPosition', [positionController::class, 'show']);
// lấy tin Position 
Route::get('getPositionById/{id}', [positionController::class, 'getPositionById']);
// update tin Position
Route::post('update/{id}', [positionController::class, 'update']);
// xoa tin Position
Route::post('destroyPosition/{id}', [positionController::class, 'destroy']);



Route::get('test/{name}', [BackupController::class, 'destroy']);