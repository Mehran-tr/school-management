<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\Setup\StudentClassController;
use App\Http\Controllers\Backend\Setup\StudentYearController;
use App\Http\Controllers\Backend\Setup\StudentGroupController;
use App\Http\Controllers\Backend\Setup\StudentShiftController;
use App\Http\Controllers\Backend\Setup\FeeCategoryController;
use App\Http\Controllers\Backend\Setup\FeeAmountController;
use App\Http\Controllers\Backend\Setup\ExamTypeController;
use App\Http\Controllers\Backend\Setup\SchoolSubjectController;
use App\Http\Controllers\Backend\Setup\AssignSubjectController;
use App\Http\Controllers\Backend\Setup\DesignationController;
use App\Http\Controllers\Backend\Student\StudentRegController;
use App\Http\Controllers\Backend\Student\StudentRoleController;

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
    return view('auth.login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.index');
    })->name('dashboard');
});

Route::get('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');


//User Management

Route::prefix('users')->group(function () {
    Route::get('/view', [UserController::class, 'userView'])->name('user.view');
    Route::get('/add', [UserController::class, 'userAdd'])->name('users.add');
    Route::post('/store', [UserController::class, 'userStore'])->name('users.store');
    Route::get('/edit/{id}', [UserController::class, 'userEdit'])->name('users.edit');
    Route::post('/update/{id}', [UserController::class, 'userUpdate'])->name('users.update');
    Route::get('/delete/{id}', [UserController::class, 'userDelete'])->name('users.delete');
});


//User Profile & Password

Route::prefix('profile')->group(function () {
    Route::get('/view', [ProfileController::class, 'profileView'])->name('profile.view');
    Route::get('/edit', [ProfileController::class, 'profileEdit'])->name('profile.edit');
    Route::post('/store', [ProfileController::class, 'profileStore'])->name('profile.store');
    Route::get('/password/view', [ProfileController::class, 'passwordView'])->name('password.view');
    Route::post('/password/update', [ProfileController::class, 'passwordUpdate'])->name('password.update');
});


//Setup management

Route::prefix('setups')->group(function () {
    Route::get('student/class/view', [StudentClassController::class, 'viewStudent'])->name('student.class.view');
    Route::get('student/class/add', [StudentClassController::class, 'studentClassAdd'])->name('student.class.add');
    Route::post('student/class/store', [StudentClassController::class, 'studentClassStore'])->name('store.student.class');
    Route::get('student/class/edit/{id}', [StudentClassController::class, 'studentClassEdit'])->name('edit.student.class');
    Route::post('student/class/update/{id}', [StudentClassController::class, 'studentClassUpdate'])->name('update.student.class');
    Route::get('/delete/{id}', [StudentClassController::class, 'studentClassDelete'])->name('student.class.delete');

    //Student Year routes
    Route::get('student/year/view', [StudentYearController::class, 'viewYear'])->name('student.year.view');
    Route::get('student/year/add', [StudentYearController::class, 'studentYearAdd'])->name('student.year.add');
    Route::post('student/year/store', [StudentYearController::class, 'studentYearStore'])->name('store.student.year');
    Route::get('student/year/edit/{id}', [StudentYearController::class, 'studentYearEdit'])->name('edit.student.year');
    Route::post('student/year/update/{id}', [StudentYearController::class, 'studentYearUpdate'])->name('update.student.year');
    Route::get('student/year/delete/{id}', [StudentYearController::class, 'studentYearDelete'])->name('student.year.delete');

    //student group view

    Route::get('student/group/view', [StudentGroupController::class, 'viewGroup'])->name('student.group.view');
    Route::get('student/group/add', [StudentGroupController::class, 'studentGroupAdd'])->name('student.group.add');
    Route::post('student/group/store', [StudentGroupController::class, 'studentGroupStore'])->name('store.student.group');
    Route::get('student/group/edit/{id}', [StudentGroupController::class, 'studentGroupEdit'])->name('edit.student.group');
    Route::post('student/group/update/{id}', [StudentGroupController::class, 'studentGroupUpdate'])->name('update.student.group');
    Route::get('student/group/delete/{id}', [StudentGroupController::class, 'studentGroupDelete'])->name('student.group.delete');

    //student Shift view

    Route::get('student/shift/view', [StudentShiftController::class, 'viewShift'])->name('student.shift.view');
    Route::get('student/shift/add', [StudentShiftController::class, 'studentShiftAdd'])->name('student.shift.add');
    Route::post('student/shift/store', [StudentShiftController::class, 'studentShiftStore'])->name('store.student.shift');
    Route::get('student/shift/edit/{id}', [StudentShiftController::class, 'studentShiftEdit'])->name('edit.student.shift');
    Route::post('student/shift/update/{id}', [StudentShiftController::class, 'studentShiftUpdate'])->name('update.student.shift');
    Route::get('student/shift/delete/{id}', [StudentShiftController::class, 'studentShiftDelete'])->name('student.shift.delete');

    //Fee Category

    Route::get('fee/category/view', [FeeCategoryController::class, 'viewFeeCat'])->name('fee.category.view');
    Route::get('fee/category/add', [FeeCategoryController::class, 'feeCatAdd'])->name('fee.category.add');
    Route::post('fee/category/store', [FeeCategoryController::class, 'feeCatStore'])->name('store.fee.category');
    Route::get('fee/category/edit/{id}', [FeeCategoryController::class, 'feeCatEdit'])->name('edit.fee.category');
    Route::post('fee/category/update/{id}', [FeeCategoryController::class, 'feeCatUpdate'])->name('update.fee.category');
    Route::get('fee/category/delete/{id}', [FeeCategoryController::class, 'feeCatDelete'])->name('fee.category.delete');

    //Fee Category Amount

    Route::get('fee/amount/view', [FeeAmountController::class, 'viewFeeAmount'])->name('fee.amount.view');
    Route::get('fee/amount/add', [FeeAmountController::class, 'feeAmountAdd'])->name('fee.amount.add');
    Route::post('fee/amount/store', [FeeAmountController::class, 'feeAmountStore'])->name('store.fee.amount');
    Route::get('fee/amount/edit/{fee_category_id}', [FeeAmountController::class, 'feeAmountEdit'])->name('edit.fee.amount');
    Route::post('fee/amount/update/{fee_category_id}', [FeeAmountController::class, 'feeAmountUpdate'])->name('update.fee.amount');
    Route::get('fee/amount/details/{fee_category_id}', [FeeAmountController::class, 'feeAmountDetails'])->name('fee.amount.details');

    //Exam Type

    Route::get('exam/type/view', [ExamTypeController::class, 'viewExamType'])->name('exam.type.view');
    Route::get('exam/type/add', [ExamTypeController::class, 'examTypeAdd'])->name('exam.type.add');
    Route::post('exam/type/store', [ExamTypeController::class, 'examTypeStore'])->name('store.exam.type');
    Route::get('exam/type/edit/{id}', [ExamTypeController::class, 'examTypeEdit'])->name('edit.exam.type');
    Route::post('exam/type/update/{id}', [ExamTypeController::class, 'examTypeUpdate'])->name('update.exam.type');
    Route::get('exam/type/delete/{id}', [ExamTypeController::class, 'examTypeDelete'])->name('exam.type.delete');


    //School Subject

    Route::get('school/subject/view', [SchoolSubjectController::class, 'viewSchoolSubject'])->name('school.subject.view');
    Route::get('school/subject/add', [SchoolSubjectController::class, 'schoolSubjectAdd'])->name('school.subject.add');
    Route::post('school/subject/store', [SchoolSubjectController::class, 'schoolSubjectStore'])->name('store.school.subject');
    Route::get('school/subject/edit/{id}', [SchoolSubjectController::class, 'schoolSubjectEdit'])->name('edit.school.subject');
    Route::post('school/subject/update/{id}', [SchoolSubjectController::class, 'schoolSubjectUpdate'])->name('update.school.subject');
    Route::get('school/subject/delete/{id}', [SchoolSubjectController::class, 'schoolSubjectDelete'])->name('school.subject.delete');

    //Assign Subject

    Route::get('assign/subject/view', [AssignSubjectController::class, 'viewAssignSubject'])->name('assign.subject.view');
    Route::get('assign/subject/add', [AssignSubjectController::class, 'addAssignSubject'])->name('assign.subject.add');
    Route::post('assign/subject/store', [AssignSubjectController::class, 'assignSubjectStore'])->name('store.assign.subject');
    Route::get('assign/subject/edit/{class_id}', [AssignSubjectController::class, 'editAssignSubject'])->name('assign.subject.edit');
    Route::post('assign/subject/update/{class_id}', [AssignSubjectController::class, 'assignSubjectUpdate'])->name('update.assign.subject');
    Route::get('assign/subject/details/{class_id}', [AssignSubjectController::class, 'assignSubjectDetails'])->name('assign.subject.details');


    //Designation View
    //School Subject

    Route::get('designation/view', [DesignationController::class, 'viewDesignation'])->name('designation.view');
    Route::get('designation/add', [DesignationController::class, 'designationAdd'])->name('designation.add');
    Route::post('designation/store', [DesignationController::class, 'designationStore'])->name('store.designation');
    Route::get('designation/edit/{id}', [DesignationController::class, 'designationEdit'])->name('edit.designation');
    Route::post('designation/update/{id}', [DesignationController::class, 'designationUpdate'])->name('update.designation');
    Route::get('designation/delete/{id}', [DesignationController::class, 'designationDelete'])->name('designation.delete');

});


//Student Registration Routes

Route::prefix('students')->group(function () {
    Route::get('/reg/view', [StudentRegController::class, 'studentRegView'])->name('student.registration.view');
    Route::get('/reg/add', [StudentRegController::class, 'studentRegistrationAdd'])->name('student.registration.add');
    Route::post('/reg/store', [StudentRegController::class, 'studentRegStore'])->name('student.registration.store');
    Route::get('/year/class/wise', [StudentRegController::class, 'studentClassYearWise'])->name('student.year.class.wise');
    Route::get('/reg/edit/{student_id}', [StudentRegController::class, 'studentRegEdit'])->name('student.registration.edit');
    Route::post('/reg/update/{student_id}', [StudentRegController::class, 'studentRegUpdate'])->name('update.student.registration');
    Route::get('/reg/promotion/{student_id}', [StudentRegController::class, 'studentRegPromotion'])->name('student.registration.promotion');
    Route::post('/reg/update/promotion/{student_id}', [StudentRegController::class, 'studentUpdatePromotion'])->name('promotion.student.registration');
    Route::get('/student/reg/detail/{student_id}', [StudentRegController::class, 'studentRegDetails'])->name('student.registration.detail');


    //Role Generator
    Route::get('/role/generate/view', [StudentRoleController::class, 'studentRoleView'])->name('role.generate.view');
    Route::get('/reg/getstudents', [StudentRoleController::class, 'getStudents'])->name('student.registration.getstudents');
    Route::post('roll/generate/store', [StudentRoleController::class, 'studentRoleStore'])->name('roll.generate.store');
});
