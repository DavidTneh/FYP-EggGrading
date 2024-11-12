<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CageController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ChickenController;
use App\Http\Controllers\EggGradingController;
use App\Http\Controllers\CullingPlanController;
use App\Http\Controllers\FeedingPlanController;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Controllers\CollectionPlanController;
use App\Http\Controllers\VaccinationPlanController;
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




Route::get('/', function () {
    return redirect('admin/login');
});

Route::get('/home', [AuthController::class, 'showLoginForm']);
// Route::get('/home/create', [HomeController::class, 'create']);
// Route::post('/home/store', [HomeController::class, 'store']);
// Route::get('/home/edit/{id}', [HomeController::class, 'edit']);
// Route::post('/home/update/{id}', [HomeController::class, 'update']);

Route::get('/admin', function () {
    return view('admin');
})->name('/admin');  // Add a name for the route


Route::get('/profile', function () {
    return view('profile');
});

Route::get('/login', function () {
    return view('login');
});

Route::prefix('admin')->name('admin.')->middleware(RedirectIfAuthenticated::class)->group(function () {
    // Admin Login Routes
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    Route::get('/register', [AuthController::class, 'register'])->name('admin.register');

    // Forgot Password Routes 
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('forgot_password');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('send_reset_link');

    // Password Reset Routes
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password/{token}', [AuthController::class, 'resetPassword'])->name('password.reset.post');
    // Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Move logout outside of RedirectIfAuthenticated and add `auth` middleware for protection
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout')->middleware('auth:web');


Route::get('/eggGrading', function () {
    return view('eggGrading');
});

Route::post('/gradeEggs', [EggGradingController::class, 'gradeEggs'])->name('/gradeEggs');
Route::get('/eggResults', [EggGradingController::class, 'index'])->name('/eggResults');
Route::get('/eggs/create', [EggGradingController::class, 'create'])->name('egg_grading.create');
Route::post('/eggs', [EggGradingController::class, 'store'])->name('egg_grading.store');
Route::get('/egg-grading/batch-edit', [EggGradingController::class, 'batchEdit'])->name('egg_grading.batchEdit');
Route::put('/egg-grading/batch-update', [EggGradingController::class, 'batchUpdate'])->name('egg_grading.batchUpdate');
Route::delete('/egg-grading/batch-delete', [EggGradingController::class, 'batchDelete'])->name('egg_grading.batchDelete');

Route::get('/collectionplan', [CollectionPlanController::class, 'index'])->name('collectionplan.index');
Route::get('/collectionplan/create', [CollectionPlanController::class, 'create'])->name('collectionplan.create');
Route::post('/collectionplan/store', [CollectionPlanController::class, 'store'])->name('collectionplan.store');
// Route::get('/collectionplan/{collectionPlan}', [CollectionPlanController::class, 'show'])->name('collectionplan.show');
Route::get('/collectionplan/{collectionPlanID}/edit', [CollectionPlanController::class, 'edit'])->name('collectionplan.edit');
Route::put('/collectionplan/update', [CollectionPlanController::class, 'update'])->name('collectionplan.update');
Route::get('/collectionplan/{collectionPlanID}/delete', [CollectionPlanController::class, 'showDelete'])->name('collectionplan.delete');
Route::delete('/collectionplan/destroy', [CollectionPlanController::class, 'destroy'])->name('collectionplan.destroy');

Route::get('/feedingplan', [FeedingPlanController::class, 'index'])->name('feedingplan.index');
Route::get('/feedingplan/create', [FeedingPlanController::class, 'create'])->name('feedingplan.create');
Route::post('/feedingplan/store', [FeedingPlanController::class, 'store'])->name('feedingplan.store');
// Route::get('/feedingplan/{feedingPlan}', [FeedingPlanController::class, 'show'])->name('feedingplan.show');
Route::get('/feedingplan/{feedingPlanID}/edit', [FeedingPlanController::class, 'edit'])->name('feedingplan.edit');
Route::put('/feedingplan/update', [FeedingPlanController::class, 'update'])->name('feedingplan.update');
Route::get('/feedingplan/{feedingPlanID}/delete', [FeedingPlanController::class, 'showDelete'])->name('feedingplan.delete');
Route::delete('/feedingplan/destroy', [FeedingPlanController::class, 'destroy'])->name('feedingplan.destroy');

Route::get('/cullingplan', [CullingPlanController::class, 'index'])->name('cullingplan.index');
Route::get('/cullingplan/create', [CullingPlanController::class, 'create'])->name('cullingplan.create');
Route::post('/cullingplan/store', [CullingPlanController::class, 'store'])->name('cullingplan.store');
Route::get('/cullingplan/{cullingPlanID}/edit', [CullingPlanController::class, 'edit'])->name('cullingplan.edit');
Route::put('/cullingplan/update', [CullingPlanController::class, 'update'])->name('cullingplan.update');
Route::get('/cullingplan/{cullingPlanID}/delete', [CullingPlanController::class, 'showDelete'])->name('cullingplan.delete');
Route::delete('/cullingplan/destroy', [CullingPlanController::class, 'destroy'])->name('cullingplan.destroy');

Route::get('/vaccinationplan', [VaccinationPlanController::class, 'index'])->name('vaccinationplan.index');
Route::get('/vaccinationplan/create', [VaccinationPlanController::class, 'create'])->name('vaccinationplan.create');
Route::post('/vaccinationplan/store', [VaccinationPlanController::class, 'store'])->name('vaccinationplan.store');
Route::get('/vaccinationplan/{vaccinationplanID}/edit', [VaccinationPlanController::class, 'edit'])->name('vaccinationplan.edit');
Route::put('/vaccinationplan/update', [VaccinationPlanController::class, 'update'])->name('vaccinationplan.update');
Route::get('/vaccinationplan/{vaccinationplanID}/delete', [VaccinationPlanController::class, 'showDelete'])->name('vaccinationplan.delete');
Route::delete('/vaccinationplan/destroy', [VaccinationPlanController::class, 'destroy'])->name('vaccinationplan.destroy');

Route::get('/cages', [CageController::class, 'index'])->name('cages.index');
Route::get('/cages/create', [CageController::class, 'create'])->name('cages.create');
Route::post('/cages/store', [CageController::class, 'store'])->name('cages.store');
Route::get('/cages/{cageID}/edit', [CageController::class, 'edit'])->name('cages.edit');
Route::put('/cages/update', [CageController::class, 'update'])->name('cages.update');
Route::get('/cages/{cageID}/delete', [CageController::class, 'showDelete'])->name('cages.showDelete');
Route::delete('/cages/destroy', [CageController::class, 'destroy'])->name('cages.destroy');

Route::get('/chickens', [ChickenController::class, 'index'])->name('chickens.index');
Route::get('/chickens/create', [ChickenController::class, 'create'])->name('chickens.create');
Route::post('/chickens/store', [ChickenController::class, 'store'])->name('chickens.store');
Route::get('/chickens/{cageID}/{breedID}', [ChickenController::class, 'showGrouped'])->name('chickens.showGrouped'); // View grouped chickens
Route::post('/chickens/group/edit', [ChickenController::class, 'editGroup'])->name('chickens.editGroup');
Route::put('/chickens/group/update', [ChickenController::class, 'updateGroup'])->name('chickens.updateGroup');
Route::post('/chickens/edit', [ChickenController::class, 'edit'])->name('chickens.edit'); // Edit individual chicken
Route::put('/chickens/update', [ChickenController::class, 'update'])->name('chickens.update');
Route::delete('/chickens/destroy', [ChickenController::class, 'destroy'])->name('chickens.destroy'); // Delete by group
Route::delete('/chickens/destroyGrouped', [ChickenController::class, 'destroyGrouped'])->name('chickens.destroyGrouped'); // Delete by group

// Route::get('/addResults', function () {
//     return view('addResults');
// });

// Route::get('/updateResults', function () {
//     return view('updateResults');
// });

// Route::get('/deleteResults', function () {
//     return view('deleteResults');
// });

Route::get('/cageManagement', function () {
    return view('cageManagement');
});

Route::get('/addCage', function () {
    return view('addCage');
});

Route::get('/updateCage', function () {
    return view('updateCage');
});

Route::get('/deleteCage', function () {
    return view('deleteCage');
});

Route::get('/chickenManagement', function () {
    return view('chickenManagement');
});

Route::get('/addChicken', function () {
    return view('addChicken');
});

Route::get('/updateChicken', function () {
    return view('updateChicken');
});

Route::get('/deleteChicken', function () {
    return view('deleteChicken');
});

Route::get('/deleteCage', function () {
    return view('deleteCage');
});

Route::get('/vaccinationplanManagement', function () {
    return view('vaccinationplanManagement');
});

Route::get('/addVaccinationPlan', function () {
    return view('addVaccinationPlan');
});

Route::get('/updateVaccinationPlan', function () {
    
    return view('updateVaccinationPlan');
});

Route::get('/deleteVaccinationPlan', function () {
    return view('deleteVaccinationPlan');
});




// Route::get('/feedingPlanManagement', function () {
//     return view('feedingPlanManagement');
// });

// Route::get('/addFeedingPlan', function () {
//     return view('addFeedingPlan');
// });

// Route::get('/updateFeedingPlan', function () {
//     return view('updateFeedingPlan');
// });

// Route::get('/deleteFeedingPlan', function () {
//     return view('deleteFeedingPlan');
// });

// Route::get('/cullingPlanManagement', function () {
//     return view('cullingPlanManagement');
// });

// Route::get('/addCullingPlan', function () {
//     return view('addCullingPlan');
// });

// Route::get('/updateCullingPlan', function () {
//     return view('updateCullingPlan');
// });

// Route::get('/deleteCullingPlan', function () {
//     return view('deleteCullingPlan');
// });

Route::get('/calender', function () {
    return view('calender');
});

Route::get('/usersManagement', function () {
    return view('usersManagement');
});

Route::get('/addUsers', function () {
    return view('addUsers');
});

Route::get('/updateUsers', function () {
    return view('updateUsers');
});

Route::get('/deleteUsers', function () {
    return view('deleteUsers');
});

Route::get('/calenderDetails', function () {
    return view('calenderDetails');
});

Route::get('/taskSchedulingManagement', function () {
    return view('taskSchedulingManagement');
});

Route::get('/addTaskScheduling', function () {
    return view('addTaskScheduling');
});

Route::get('/updateTaskScheduling', function () {
    return view('updateTaskScheduling');
});

Route::get('/deleteTaskScheduling', function () {
    return view('deleteTaskScheduling');
});


Route::get('/reportManagement', function () {
    return view('reportManagement');
});

// Route for the Summary Report
Route::get('/reports/summary', [ReportController::class, 'summaryReport'])->name('reports.summary');

// Route for the Details Report
Route::get('/reports/details', [ReportController::class, 'detailsReport'])->name('reports.details');

// Route for the Exception Report
Route::get('/reports/exceptions', [ReportController::class, 'exceptionReport'])->name('reports.exceptions');

Route::get('/forgetPassword', function () {
    return view('forgetPassword');
});

Route::get('/forgetPasswordReset', function () {
    return view('forgetPasswordReset');
});