<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CageController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ChickenController;
use App\Http\Controllers\EggGradingController;
use App\Http\Controllers\CullingPlanController;
use App\Http\Controllers\FeedingPlanController;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Controllers\CollectionPlanController;
use App\Http\Controllers\TaskSchedulingController;
use App\Http\Controllers\VaccinationPlanController;
use App\Http\Controllers\VaccinationRecordsController;

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

Route::middleware(['auth', 'Admin'])->group(function () {

    Route::get('/users', [UserController::class, 'index'])->name('users.index'); // List all users
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create'); // Show create user form
    Route::post('/users/store', [UserController::class, 'store'])->name('users.store'); // Store new user
    Route::post('/users/edit', [UserController::class, 'edit'])->name('users.edit'); // Show edit user form
    Route::put('/users/update', [UserController::class, 'update'])->name('users.update'); // Update user
    Route::post('/users/delete', [UserController::class, 'showDelete'])->name('users.showDelete'); // Show delete confirmation
    Route::delete('/users/destroy', [UserController::class, 'destroy'])->name('users.destroy'); // Delete user
    Route::post('/users/disable', [UserController::class, 'disable'])->name('users.disable');

    Route::get('/task-schedulings', [TaskSchedulingController::class, 'index'])->name('task-schedulings.index'); // List all task schedulings
    Route::get('/task-schedulings/create', [TaskSchedulingController::class, 'create'])->name('task-schedulings.create'); // Show create task scheduling form
    Route::post('/task-schedulings/store', [TaskSchedulingController::class, 'store'])->name('task-schedulings.store'); // Store new task scheduling
    Route::post('/task-schedulings/edit', [TaskSchedulingController::class, 'edit'])->name('task-schedulings.edit'); // Show edit task scheduling form
    Route::put('/task-schedulings/update', [TaskSchedulingController::class, 'update'])->name('task-schedulings.update'); // Update task scheduling
    Route::post('/task-schedulings/delete', [TaskSchedulingController::class, 'showDelete'])->name('task-schedulings.showDelete'); // Show delete confirmation
    Route::delete('/task-schedulings/destroy', [TaskSchedulingController::class, 'destroy'])->name('task-schedulings.destroy'); // Delete task scheduling
    Route::post('/task-schedulings/view', [TaskSchedulingController::class, 'view'])->name('task-schedulings.view');

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

    // Vaccination Record Routes
    Route::get('/vaccination-records', [VaccinationRecordsController::class, 'index'])->name('vaccination_records.index');
    Route::get('/vaccination-records/create', [VaccinationRecordsController::class, 'create'])->name('vaccination_records.create');
    Route::post('/vaccination-records/store', [VaccinationRecordsController::class, 'store'])->name('vaccination_records.store');
    Route::get('/vaccination-records/edit', [VaccinationRecordsController::class, 'edit'])->name('vaccination_records.edit');
    Route::put('/vaccination-records/{id}/update', [VaccinationRecordsController::class, 'update'])->name('vaccination_records.update');
    Route::post('vaccination_records/editGroup', [VaccinationRecordsController::class, 'editGroup'])->name('vaccination_records.editGroup');
    // Route::put('vaccination_records/updateGroup', [VaccinationRecordsController::class, 'updateGroup'])->name('vaccination_records.updateGroup');
    Route::delete('/vaccination-records/{id}/delete', [VaccinationRecordsController::class, 'destroy'])->name('vaccination_records.destroy');
    Route::delete('vaccination_records/destroyGroup', [VaccinationRecordsController::class, 'destroyGroup'])->name('vaccination_records.destroyGroup');
    Route::put('/vaccination_records/update-group', [VaccinationRecordsController::class, 'updateGroup'])->name('vaccination_records.updateGroup');
    Route::delete('/vaccination_records/deleteGroup', [VaccinationRecordsController::class, 'deleteGroup'])->name('vaccination_records.deleteGroup');

});

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', function () {
        return view('profile');
    });

    // Profile viewing and editing
    Route::get('/profile', [AuthController::class, 'showProfile'])->name('profile.show');
    Route::post('/profile/update', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/update-picture', [AuthController::class, 'updateProfilePicture'])->name('profile.updatePicture');

    // Password update
    Route::post('/profile/update-password', [AuthController::class, 'updatePassword'])->name('profile.updatePassword');

    // Move logout outside of RedirectIfAuthenticated and add `auth` middleware for protection
    Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout')->middleware('auth:web');

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

    // Route::get('/eggGrading', function () {
    //     return view('eggGrading');
    // });

    Route::get('/eggGrading',[EggGradingController::class, 'eggGrading'])->name('eggGrading');
    Route::post('/gradeEggs', [EggGradingController::class, 'gradeEggs'])->name('/gradeEggs');
    Route::get('/eggResults', [EggGradingController::class, 'index'])->name('/eggResults');
    Route::get('/eggs/create', [EggGradingController::class, 'create'])->name('egg_grading.create');
    Route::post('/eggs', [EggGradingController::class, 'store'])->name('egg_grading.store');
    Route::get('/egg-grading/batch-edit', [EggGradingController::class, 'batchEdit'])->name('egg_grading.batchEdit');
    Route::put('/egg-grading/batch-update', [EggGradingController::class, 'batchUpdate'])->name('egg_grading.batchUpdate');
    Route::delete('/egg-grading/batch-delete', [EggGradingController::class, 'batchDelete'])->name('egg_grading.batchDelete');

    // Route::get('/task-schedulingsStatus', [TaskSchedulingController::class, 'index'])->name('task-schedulings.index'); // List all task schedulings
    // Route::post('/task-schedulingsStatus/edit', [TaskSchedulingController::class, 'edit'])->name('task-schedulings.edit'); // Show edit task scheduling form
    // Route::put('/task-schedulingsStatus/update', [TaskSchedulingController::class, 'update'])->name('task-schedulings.update'); // Update task scheduling


    // Route to list assigned tasks
    Route::get('/employee/tasks', [TaskSchedulingController::class, 'listAssignedTasks'])->name('employee.listAssignedTasks');

    // Route to show the update form
    // Show the form for updating task status
    Route::post('/employee/task-status/edit', [TaskSchedulingController::class, 'showUpdateTaskStatusForm'])->name('employee.showUpdateTaskStatusForm');

    // Handle the form submission for updating task status
    Route::post('/employee/task-status/update', [TaskSchedulingController::class, 'updateTaskStatus'])->name('employee.updateTaskStatus');

    Route::post('/chickens/printQR', [ChickenController::class, 'printQR'])->name('chickens.printQR');

    Route::post('/vaccination-records/edit-group', [TaskSchedulingController::class, 'showUpdateVaccinationStatusForm'])->name('employee.showUpdateVaccinationStatusForm');
    Route::post('/vaccination-records/update-group', [TaskSchedulingController::class, 'updateVaccinationGroupStatus'])->name('employee.updateVaccinationGroupStatus');

    Route::put('/profile/changePassword', [AuthController::class, 'changePassword'])->name('profile.changePassword');


});

Route::middleware(['auth', 'Employee'])->group(function () {

});

Route::get('/home', [AuthController::class, 'showLoginForm']);
// Route::get('/home/create', [HomeController::class, 'create']);
// Route::post('/home/store', [HomeController::class, 'store']);
// Route::get('/home/edit/{id}', [HomeController::class, 'edit']);
// Route::post('/home/update/{id}', [HomeController::class, 'update']);

Route::get('/admin', function () {
    return view('admin');
})->name('/admin');  // Add a name for the route




// Route::get('/login', function () {
//     return view('login');
// });

Route::prefix('admin')->name('admin.')->middleware(RedirectIfAuthenticated::class)->group(function () {
    // Admin Login Routes
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');

    // Handle registration submission
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');

    // Forgot Password Routes 
    // Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('forgot_password');
    // Route::get('/forgot-password', [AuthController::class, 'sendResetLink'])->name('send_reset_link');

    // Password Reset Routes
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password/{token}', [AuthController::class, 'resetPassword'])->name('password.reset.post');
    // Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Route::get('/admin/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('admin.forgotPassword');
Route::get('/admin/resetemail', [AuthController::class, 'showEmailResetForm'])->name('admin.sendEmail');
Route::post('/admin/send-reset-link', [AuthController::class, 'sendResetLink'])->name('admin.sendResetLink');
Route::get('/admin/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('admin.resetPasswordForm');
Route::post('/admin/reset-password/{token}', [AuthController::class, 'resetPassword'])->name('admin.resetPassword');




Route::get('/task-schedulings/calendar', [TaskSchedulingController::class, 'showCalendar'])->name('task-schedulings.calendar');

Route::get('/calendar', [TaskSchedulingController::class, 'showCalendar'])->name('calendar');
Route::get('/calendar-data', [TaskSchedulingController::class, 'getCalendarData'])->name('calendar-data');

// Route::get('/calender', function () {
//     return view('calender');
// });

// Route::get('/usersManagement', function () {
//     return view('usersManagement');
// });

// Route::get('/addUsers', function () {
//     return view('addUsers');
// });

// Route::get('/updateUsers', function () {
//     return view('updateUsers');
// });

// Route::get('/deleteUsers', function () {
//     return view('deleteUsers');
// });

// Route::get('/calenderDetails', function () {
//     return view('calenderDetails');
// });

// Route::get('/taskSchedulingManagement', function () {
//     return view('taskSchedulingManagement');
// });

// Route::get('/addTaskScheduling', function () {
//     return view('addTaskScheduling');
// });

// Route::get('/updateTaskScheduling', function () {
//     return view('updateTaskScheduling');
// });

// Route::get('/deleteTaskScheduling', function () {
//     return view('deleteTaskScheduling');
// });


Route::get('/reportManagement', function () {
    return view('reportManagement');
});

// Route for the Summary Report
Route::get('/reports/summary', [ReportController::class, 'summaryReport'])->name('reports.summary');

// Route for the Details Report
Route::get('/reports/details', [ReportController::class, 'detailsReport'])->name('reports.details');

Route::get('/forgetPassword', function () {
    return view('forgetPassword');
});

Route::get('/dashboard', [ReportController::class, 'index'])->name('dashboard.index');


Route::get('/forgetPasswordReset', function () {
    return view('forgetPasswordReset');
});