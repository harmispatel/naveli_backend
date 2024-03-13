<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\QuestionController;
use App\Http\Controllers\Api\ForgotPasswordController;
use App\Http\Controllers\Api\GeneralSettingController;
use App\Http\Controllers\Api\HealthMixController;
use App\Http\Controllers\Api\SuperWomancontroller;
use App\Http\Controllers\Api\PeriodsInfoController;
use App\Http\Controllers\Api\TrackController;
use App\Http\Controllers\Api\ForumController;
use App\Http\Controllers\Api\AskYourQuestionController;
use App\Models\generalSetting;

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

// User
 Route::post('signup', [UserController::class, 'signup']);
 Route::post('login', [UserController::class, 'login']);
 Route::post('verify-mobile',[UserController::class,'VerifyMobileNumber']);
 Route::post('userList', [UserController::class, 'userList'])->middleware('auth:sanctum');
 Route::post('update', [UserController::class, 'update'])->middleware('auth:sanctum');
 Route::post('destroy',[UserController::class,'destroy'])->middleware('auth:sanctum');
 Route::get('user-details',[UserController::class,'userDetail'])->middleware('auth:sanctum');
 Route::post('user-update-details',[UserController::class,'userUpdateDetails'])->middleware('auth:sanctum');


// Question
Route::post('questionlist',[QuestionController::class,'questionlist'])->middleware('auth:sanctum');
Route::post('questiondestroy',[QuestionController::class,'destroy'])->middleware('auth:sanctum');
Route::post('question-answer',[QuestionController::class,'questionAnswer'])->middleware('auth:sanctum');
Route::get('question-answers',[QuestionController::class,'getQuestionAnswers'])->middleware('auth:sanctum');

//questionType
Route::get('questionType',[QuestionController::class,'questionTypeList']);

//forgetPassword
Route::post('sendOtp',[ForgotPasswordController::class,'sendOtp']);
Route::post('checkOtp',[ForgotPasswordController::class,'checkOtp']);
Route::post('confirmPassword',[ForgotPasswordController::class,'confirmPassword'])->middleware('auth:sanctum');


// Ask Your Question
Route::post('userQuestionStore',[AskYourQuestionController::class,'userQuestionStore'])->middleware('auth:sanctum');
Route::get('adminAnswer',[AskYourQuestionController::class,'adminAnswerList']);

//generalsetting
Route::post('getGeneralSetting',[GeneralSettingController::class,'getGeneralSetting']);

//periods-info
Route::post('periods-info',[PeriodsInfoController::class,'periodsInfo']);

//Super Woman
Route::post('Super-Woman',[SuperWomancontroller::class,'SuperWoman']);


//logout
Route::get('logout',[UserController::class,'logout'])->middleware('auth:sanctum');

//news
Route::get('newsDetails',[UserController::class,'newsDetails'])->middleware('auth:sanctum');

//medicine
Route::get('medicineList',[UserController::class,'medicineList'])->middleware('auth:sanctum');

//ailmentsList
Route::get('/ailmentsList',[UserController::class,'ailmentsList'])->middleware('auth:sanctum');

//posts
Route::post('get-all-posts',[UserController::class,'getAllPosts'])->middleware('auth:sanctum');
// Route::post('post-like-operation',[UserController::class,'postlikeOperation'])->middleware('auth:sanctum');

//userSymptomsLogs
Route::post('/storeUserSymptomsLogs',[UserController::class,'storeUserSymptomsLogs'])->middleware('auth:sanctum');
Route::get('/listuserSymptomsLogs',[UserController::class,'listuserSymptomsLogs'])->middleware('auth:sanctum');


//TrackController
Route::post('/track/storeUserMedicationsDetail',[TrackController::class,'storeUserMedicationsDetail'])->middleware('auth:sanctum');
Route::get('/track/getStoredMedicationsDetail',[TrackController::class,'getStoredMedicationsDetail'])->middleware('auth:sanctum');
Route::post('/track/storeBmiCalculatorDetail',[TrackController::class,'storeBmiCalculatorDetail'])->middleware('auth:sanctum');
Route::post('/track/storeWeightDetail',[TrackController::class,'storeWeightDetail'])->middleware('auth:sanctum');
Route::post('/track/storeUserAilmentsDetail',[TrackController::class,'storeUserAilmentsDetail'])->middleware('auth:sanctum');
Route::get('/track/getStoredAilmentsDetail',[TrackController::class,'getStoredAilmentsDetail'])->middleware('auth:sanctum');

//HealthMixController
Route::post('/healthMixPostList',[HealthMixController::class,'index'])->middleware('auth:sanctum');
Route::post('/userHealthMixLikeDislike',[HealthMixController::class,'likeDislike'])->middleware('auth:sanctum');

//ForumController
Route::get('/forumsList',[ForumController::class,'forumsList'])->middleware('auth:sanctum');
Route::post('/forumCommentStore',[ForumController::class,'forumCommentStore'])->middleware('auth:sanctum');
Route::post('/getUsersCommentList',[ForumController::class,'getUsersCommentList']);
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();

// });

