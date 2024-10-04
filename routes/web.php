<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\EggGradingController;
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
    return view('welcome');
});

Route::get('/home', [HomeController::class, 'index']);
Route::get('/home/create', [HomeController::class, 'create']);
Route::post('/home/store', [HomeController::class, 'store']);
Route::get('/home/edit/{id}', [HomeController::class, 'edit']);
Route::post('/home/update/{id}', [HomeController::class, 'update']);

Route::get('/admin', function () {
    return view('admin');
});

Route::get('/profile', function () {
    return view('profile');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/register', function () {
    return view('register');
});

Route::get('/eggGrading', function () {
    return view('eggGrading');
});

Route::get('/eggResults', [EggGradingController::class, 'index'])->name('/eggResults');
Route::get('/eggs/create', [EggGradingController::class, 'create'])->name('egg_grading.create');
Route::post('/eggs', [EggGradingController::class, 'store'])->name('egg_grading.store');
Route::get('/eggs/{id}/edit', [EggGradingController::class, 'edit'])->name('egg_grading.edit');
Route::put('/eggs/{id}', [EggGradingController::class, 'update'])->name('egg_grading.update');
Route::delete('/eggs/{id}', [EggGradingController::class, 'destroy'])->name('egg_grading.destroy');

Route::get('/addResults', function () {
    return view('addResults');
});

Route::get('/updateResults', function () {
    return view('updateResults');
});

Route::get('/deleteResults', function () {
    return view('deleteResults');
});

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


Route::get('/collectionPlanManagement', function () {
    return view('collectionPlanManagement');
});

Route::get('/addCollectionPlan', function () {
    return view('addCollectionPlan');
});

Route::get('/updateCollectionPlan', function () {
    return view('updateCollectionPlan');
});

Route::get('/deleteCollectionPlan', function () {
    return view('deleteCollectionPlan');
});

Route::get('/feedingPlanManagement', function () {
    return view('feedingPlanManagement');
});

Route::get('/addFeedingPlan', function () {
    return view('addFeedingPlan');
});

Route::get('/updateFeedingPlan', function () {
    return view('updateFeedingPlan');
});

Route::get('/deleteFeedingPlan', function () {
    return view('deleteFeedingPlan');
});

Route::get('/cullingPlanManagement', function () {
    return view('cullingPlanManagement');
});

Route::get('/addCullingPlan', function () {
    return view('addCullingPlan');
});

Route::get('/updateCullingPlan', function () {
    return view('updateCullingPlan');
});

Route::get('/deleteCullingPlan', function () {
    return view('deleteCullingPlan');
});

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