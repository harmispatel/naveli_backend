<?php

use App\Http\Controllers\Admin\{DashboardController, RoleController, AuthController, UserController};
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AgeController;
use App\Http\Controllers\Api\UserSymptomsLogsController;
use App\Http\Controllers\GeneralSettingController;
use App\Http\Controllers\ContentUploadController;
use App\Http\Controllers\HealthMixController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\NewsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\pdfController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AilmentController;
use App\Http\Controllers\QuestionTypeController;
use App\Http\Controllers\AskYourQuestionController;
use App\Http\Controllers\ForumCommentController;
use App\Http\Controllers\ForumController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|

*/

// Cache Clear Route
Route::get('config-clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    return redirect()->route('dashboard');
});


// Default Route
Route::get('/', function () {
    // return view('frontend.welcome');
    return redirect()->route('admin.login');
});

// ADMIN ROUTES
Route::group(['prefix' => 'admin'], function () {

    Route::get('/', function () {
        return redirect()->route('admin.login');
    });

    // Admin Auth Routes
    Route::get('/login', function () {
        if (auth()->check()) {
            return redirect()->route('dashboard');
        } else {
            return view('auth.login'); // Replace 'your_login_view' with the actual view name
        }
    })->name('admin.login');
    Route::get('/login', [AuthController::class, 'showAdminLogin'])->name('admin.login');
    Route::post('/do/login', [AuthController::class, 'Adminlogin'])->name('admin.do.login');
    Route::get('/forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
    Route::post('/forget-password', [ForgotPasswordController::class, 'submitforgetpasswordform'])->name('forget.password.post');
    Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showresetpasswordform'])->name('reset.password.get');
    Route::post('/reset-password', [ForgotPasswordController::class, 'submitresetpasswordform'])->name('reset.password.post');

    // Route Access if Authanticated User
    Route::group(['middleware' => 'is_admin'], function () {

        // Dashboard
        
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Roles
        Route::get('roles', [RoleController::class, 'index'])->name('roles');
        Route::get('roles/create', [RoleController::class, 'create'])->name('roles.create');
        Route::post('roles/store', [RoleController::class, 'store'])->name('roles.store');
        Route::get('roles/edit/{id}', [RoleController::class, 'edit'])->name('roles.edit');
        Route::post('roles/update', [RoleController::class, 'update'])->name('roles.update');
        Route::post('roles/destroy', [RoleController::class, 'destroy'])->name('roles.destroy');

        // User
        Route::get('users', [UserController::class, 'index'])->name('users');
        Route::get('users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('users/store', [UserController::class, 'store'])->name('users.store');
        Route::post('users/status', [UserController::class, 'status'])->name('users.status');
        Route::post('users/update', [UserController::class, 'update'])->name('users.update');
        Route::get('users/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
        Route::post('users/destroy', [UserController::class, 'destroy'])->name('users.destroy');
        Route::get('profile/edit/{id}', [UserController::class, 'profileEdit'])->name('profile.edit');
        Route::post('profile/update', [UserController::class, 'profileUpdate'])->name('profile.update');

        //age
        Route::controller(AgeController::class)->group(function () {
            Route::get('age', 'index')->name('age.index');
            Route::get('age/load', 'load')->name('age.load');
            Route::get('age/create', 'create')->name('age.create');
            Route::post('age/store', 'store')->name('age.store');
            Route::get('age/edit/{id}', 'edit')->name('age.edit');
            Route::post('age/update', 'update')->name('age.update');
            Route::get('age/destroy/{id}', 'delete')->name('age.destroy');
        });

        //question
        Route::get('question', [QuestionController::class, 'index'])->name('question.index');
        Route::get('question/create', [QuestionController::class, 'create'])->name('question.create');
        Route::post('question/store', [QuestionController::class, 'store'])->name('question.store');
        Route::get('question/edit/{id}', [QuestionController::class, 'edit'])->name('question.edit');
        Route::post('/question/update', [QuestionController::class, 'update'])->name('question.update');
        Route::get('question/destroy/{id}', [QuestionController::class, 'delete'])->name('question.destroy');
        Route::get('question/optionView/{id}', [QuestionController::class, 'questionOptionView'])->name('question.optionView');

        //User Ask Question
        Route::get('userAskQuestion', [AskYourQuestionController::class, 'index'])->name('userAskQuestion.index');
        Route::get('userAskQuestion/create', [AskYourQuestionController::class, 'create'])->name('userAskQuestion.create');
        Route::post('userAskQuestion/store', [AskYourQuestionController::class, 'store'])->name('userAskQuestion.store');
        Route::get('userAskQuestion/edit/{id}', [AskYourQuestionController::class, 'edit'])->name('userAskQuestion.edit');
        Route::post('userAskQuestion/update', [AskYourQuestionController::class, 'update'])->name('userAskQuestion.update');
        Route::get('userAskQuestion/destroy/{id}', [AskYourQuestionController::class, 'delete'])->name('userAskQuestion.destroy');

        //question Type
        Route::get('questionType', [QuestionTypeController::class, 'index'])->name('questionType.index');
        Route::get('questionType/create', [QuestionTypeController::class, 'create'])->name('questionType.create');
        Route::post('questionType/store', [QuestionTypeController::class, 'store'])->name('questionType.store');
        Route::get('questionType/edit/{id}', [QuestionTypeController::class, 'edit'])->name('questionType.edit');
        Route::post('questionType/update', [QuestionTypeController::class, 'update'])->name('questionType.update');
        Route::get('questionType/destroy/{id}', [QuestionTypeController::class, 'destroy'])->name('questionType.destroy');

        // Woman in News
        Route::controller(NewsController::class)->group(function () {
            Route::get('woman-in-news', 'index')->name('woman-in-news.index');
            Route::get('woman-in-news/load', 'load')->name('woman-in-news.load');
            Route::get('woman-in-news/create', 'create')->name('woman-in-news.create');
            Route::post('woman-in-news/store', 'store')->name('woman-in-news.store');
            Route::get('woman-in-news/edit/{id}', 'edit')->name('woman-in-news.edit');
            Route::post('woman-in-news/update', 'update')->name('woman-in-news.update');
            Route::get('woman-in-news/destroy/{id}', 'destroy')->name('woman-in-news.destroy');
        });


        //posts
        Route::controller(PostController::class)->group(function () {
            Route::get('posts',  'index')->name('posts.index');
            Route::get('posts/create',  'create')->name('posts.create');
            Route::post('posts/store',  'store')->name('posts.store');
            Route::get('posts/edit/{id}',  'edit')->name('posts.edit');
            Route::post('posts/update',  'update')->name('posts.update');
            Route::get('posts/destroy/{id}',  'destroy')->name('posts.destroy');
        });

        //healthMix
        Route::get('healthMix', [HealthMixController::class, 'index'])->name('healthMix.index');
        Route::get('healthMix/create', [HealthMixController::class, 'create'])->name('healthMix.create');
        Route::post('healthMix/store', [HealthMixController::class, 'store'])->name('healthMix.store');
        Route::get('healthMix/edit/{id}', [HealthMixController::class, 'edit'])->name('healthMix.edit');
        Route::post('healthMix/update', [HealthMixController::class, 'update'])->name('healthMix.update');
        Route::get('healthMix/destroy/{id}', [HealthMixController::class, 'destroy'])->name('healthMix.destroy');

        //notification
        Route::get('notification', [UserController::class, 'notification'])->name('notification');

        // Logout Admin
        Route::get('/logout', [DashboardController::class, 'adminLogout'])->name('admin.logout');

        //general Setting
        Route::get('generalsetting/create', [GeneralSettingController::class, 'create'])->name('generalSetting');
        Route::post('generalsetting/store', [GeneralSettingController::class, 'store'])->name('generalSetting.store');

        //content upload
        Route::get('contentupload/create', [ContentUploadController::class, 'create'])->name('ContentUpload');
        Route::post('contentupload/store', [ContentUploadController::class, 'store'])->name('ContentUpload.store');
        Route::get('contentupload/user_id', [ContentUploadController::class, 'getUserID'])->name('getUserID');

        // Medicine
        Route::controller(MedicineController::class)->group(function () {
            Route::get('medicine', 'index')->name('medicine.index');
            Route::get('medicine/create', 'create')->name('medicine.create');
            Route::post('medicine/store', 'store')->name('medicine.store');
            Route::get('medicine/edit/{id}', 'edit')->name('medicine.edit');
            Route::post('medicine/update', 'update')->name('medicine.update');
            Route::get('medicine/destroy/{id}', 'destroy')->name('medicine.destroy');
        });

        // ailments
        Route::get('ailments', [AilmentController::class, 'index'])->name('ailments.index');
        Route::get('ailments/create', [AilmentController::class, 'create'])->name('ailments.create');
        Route::post('ailments/store', [AilmentController::class, 'store'])->name('ailments.store');
        Route::get('ailments/edit/{id}', [AilmentController::class, 'edit'])->name('ailments.edit');
        Route::post('ailments/update', [AilmentController::class, 'update'])->name('ailments.update');
        Route::get('ailments/destroy/{id}', [AilmentController::class, 'destroy'])->name('ailments.destroy');

        //pdf
        Route::get('/generate-pdf', [pdfController::class, 'generatePDF']);

        //Forums
        Route::get('/forums', [ForumController::class, 'index'])->name('forums.index');
        Route::get('/forums/create', [ForumController::class, 'create'])->name('forums.create');
        Route::post('/forums/store', [ForumController::class, 'store'])->name('forums.store');
        Route::get('/getsubcategory/{categoryId}', [ForumController::class, 'getSubCategory'])->name('forums.getsubcategory');
        Route::get('forums/edit/{id}', [ForumController::class, 'edit'])->name('forums.edit');
        Route::post('forums/update', [ForumController::class, 'update'])->name('forums.update');
        Route::get('forums/destroy/{id}', [ForumController::class, 'destroy'])->name('forums.destroy');

        //forum-comments
        Route::get('/forum-comments', [ForumCommentController::class, 'index'])->name('forumcomments.index');
        Route::get('/forum-comments/reply/{id}', [ForumCommentController::class, 'reply'])->name('forumcomments.reply');
        Route::Post('/forum-comments/reply/store', [ForumCommentController::class, 'storeReply'])->name('forumcomments.reply.store');
        Route::get('/forum-comments/destroy/{id}', [ForumCommentController::class, 'destroy'])->name('forumcomments.destroy');
    });
});
