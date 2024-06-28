<?php

use App\Http\Controllers\Admin\{ SettingController , AttendanceController, AttendanceReportController, Dashboardcontroller, DepartmentController, DesignationController, EmployeeController, EmployeeExperienceController, EmployeeQualificationController, LeaveController, MenuAccessController, MenuSettingController, NotificationController, PDFController, ShiftController, UserAccessController, UserController};
use App\Http\Controllers\AuthController;
use App\Models\Attendance;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// GET ICONS

Route::get('/svg-list', function () {
    $svgFilePath = public_path('assets/fonts/Feather144f.svg');

    // Load SVG content
    $svgContent = file_get_contents($svgFilePath);

    // Extract glyph names
    $matches = [];
    preg_match_all('/glyph-name="([^"]+)"/', $svgContent, $matches);

    // Append to icon list
    $iconList = [];
    foreach ($matches[1] as $glyphName) {
        $iconList[] = ['file' => $glyphName, 'class' => strtolower($glyphName)];
    }

    return response()->json($iconList);
});
//Auth Routes
Route::get('login', [AuthController::class,'login'])->name('auth.login');
Route::get('forget_password', [AuthController::class,'forget_password'])->name('auth.forget.password');
Route::get('reset_password_view', [AuthController::class,'password_reset_view'])->name('password.reset.view');
Route::post('reset_password', [AuthController::class,'password_reset'])->name('password.reset');
Route::post('verify', [AuthController::class,'verify'])->name('auth.verify.email');
Route::get('logout', [AuthController::class,'logout'])->name('auth.logout');
Route::post('authenticate', [AuthController::class,'authenticate'])->name('auth.authenticate');

// Admin Panel Routes

Route::prefix('/')->middleware('auth')->group(function(){
    Route::get('/', [Dashboardcontroller::class,'index'])->name('dashboard');
    Route::get('profile/setting/{id?}' , [AuthController::class,'profile_settings'])->name('profile_settings');
    // Users Settings
    Route::prefix('users/')->group(function(){
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::get('/create/{id?}' , [UserController::class ,'create'])->name('users.create');
        Route::post('/store/{id?}' , [UserController::class ,'store'])->name('users.store');
        Route::post('/check_users' , [UserController::class ,'check_user'])->name('users.check');
        Route::post('/user_status/{id?}' , [UserController::class ,'status'])->name('users.status');
        Route::get('/delete/{id?}' , [UserController::class , 'delete'])->name('users.delete');
        Route::get('/user/access/{id?}' , [UserAccessController::class , 'index'])->name('users.role');
        Route::post('/change/access/{id?}' , [UserAccessController::class , 'changeAccess'])->name('users.change.access');
    });

     // Menu Settings
     Route::prefix('menu/')->group(function(){
        Route::get('/' , [MenuSettingController::class ,'index'])->name('menusettings.index');
        Route::get('/create/{id?}' , [MenuSettingController::class ,'create'])->name('menusettings.create');
        Route::get('/menuaccess/{id?}' , [MenuAccessController::class ,'index'])->name('menusettings.access');
        Route::post('/store/{id?}' , [MenuSettingController::class ,'store'])->name('menusettings.store');
        Route::post('/changeAccess/{id?}' , [MenuAccessController::class ,'changeAccess'])->name('menusettings.changeAccess');
        Route::post('/check_routes' , [MenuSettingController::class ,'check_routes'])->name('menusettings.check_routes');
        Route::get('/delete/{id?}' , [MenuSettingController::class , 'delete'])->name('menusettings.delete');
    });
     Route::prefix('department/')->group(function(){
        Route::get('/' , [DepartmentController::class ,'index'])->name('departments.index');
        Route::get('/trash' , [DepartmentController::class , 'trash'])->name('departments.trash');
        Route::get('/create/{id?}' , [DepartmentController::class ,'create'])->name('departments.create');
        Route::post('/store/{id?}' , [DepartmentController::class ,'store'])->name('departments.store');
        Route::get('/delete/{id?}' , [DepartmentController::class , 'delete'])->name('departments.delete');
        Route::get('/destroy/{id?}' , [DepartmentController::class , 'destroy'])->name('departments.destroy');
        Route::get('/restore/{id?}' , [DepartmentController::class , 'restore'])->name('departments.restore');
    });
     Route::prefix('designation/')->group(function(){
        Route::get('/' , [DesignationController::class ,'index'])->name('designations.index');
        Route::get('/trash' , [DesignationController::class ,'trash'])->name('designations.trash');
        Route::get('/create/{id?}' , [DesignationController::class ,'create'])->name('designations.create');
        Route::post('/store/{id?}' , [DesignationController::class ,'store'])->name('designations.store');
        Route::get('/delete/{id?}' , [DesignationController::class , 'delete'])->name('designations.delete');
        Route::get('/destroy/{id?}' , [DesignationController::class , 'destroy'])->name('designations.destroy');
        Route::get('/restore/{id?}' , [DesignationController::class , 'restore'])->name('designations.restore');
    });
     Route::prefix('shifts/')->group(function(){
        Route::get('/' , [ShiftController::class ,'index'])->name('shifts.index');
        Route::get('/trash' , [ShiftController::class ,'trash'])->name('shifts.trash');
        Route::get('/create/{id?}' , [ShiftController::class ,'create'])->name('shifts.create');
        Route::post('/store/{id?}' , [ShiftController::class ,'store'])->name('shifts.store');
        Route::get('/delete/{id?}' , [ShiftController::class , 'delete'])->name('shifts.delete');
        Route::get('/destroy/{id?}' , [ShiftController::class , 'destroy'])->name('shifts.destroy');
        Route::get('/restore/{id?}' , [ShiftController::class , 'restore'])->name('shifts.restore');
    });
    // Employees Section
    Route::prefix('employees/')->group(function(){
        Route::get('/' , [EmployeeController::class,'index'])->name('employees.index');
        Route::get('/details/{id}' , [EmployeeController::class,'employee_details'])->name('employees.details');
        Route::get('/trash' , [EmployeeController::class,'trash'])->name('employees.trash');
        Route::get('/create/{id?}' , [EmployeeController::class,'create'])->name('employees.create');
        Route::get('/delete/{id?}' , [EmployeeController::class,'delete'])->name('employees.delete');
        Route::get('/delete_document/{id?}' , [EmployeeController::class,'delete_document'])->name('employees.document.delete');
        Route::get('/destroy/{id?}' , [EmployeeController::class,'destroy'])->name('employees.destroy');
        Route::get('/documents/{id?}' , [EmployeeController::class,'documents'])->name('employees.documents');
        Route::get('/restore/{id?}' , [EmployeeController::class,'restore'])->name('employees.restore');
        Route::GET('/state/{id?}' , [EmployeeController::class,'state'])->name('state.get');
        Route::GET('/city/{id?}' , [EmployeeController::class,'city'])->name('city.get');
        Route::post('/store/{id?}' , [EmployeeController::class ,'store'])->name('employees.store');
        Route::get('shift/designations/{id?}' , [EmployeeController::class,'designation_and_shift'])->name('shift.designations');
    });
    Route::prefix('employees/qualification')->group(function(){
        Route::get('/edit/{id?}' , [EmployeeQualificationController::class ,'edit'])->name('employees.qualification.edit');
        Route::post('/store/{id?}' , [EmployeeQualificationController::class ,'store'])->name('employees.qualification.store');
        Route::get('/delete/{id?}' , [EmployeeQualificationController::class ,'delete'])->name('employees.qualification.delete');
        Route::get('/qualifications/{id?}' , [EmployeeQualificationController::class ,'get_qualification'])->name('employees.get.qualification');
    });
    Route::prefix('employees/experience')->group(function(){
        Route::post('/store/{id?}' , [EmployeeExperienceController::class ,'store'])->name('employees.experience.store');
        Route::Get('/edit/{id?}' , [EmployeeExperienceController::class ,'edit'])->name('employees.experience.edit');
        Route::Get('/delete/{id?}' , [EmployeeExperienceController::class ,'delete'])->name('employees.experience.delete');
        Route::Get('/get_experience/{id?}' , [EmployeeExperienceController::class ,'get_experience'])->name('employees.get.experience');
    });
    Route::prefix('employees/attendance')->group(function(){

        Route::post('/checkin' , [AttendanceController::class ,'checkin'])->name('attendance.checkin');
        Route::post('/checkout' , [AttendanceController::class ,'checkout'])->name('attendance.checkout');
        Route::Get('/edit/{id?}' , [AttendanceController::class ,'edit'])->name('attendance.edit');
        Route::Get('/delete/{id?}' , [AttendanceController::class ,'delete'])->name('attendance.delete');
        Route::Get('/get_experience/{id?}' , [AttendanceController::class ,'get_experience'])->name('attendance.get');
    });
    Route::prefix('attendance/reports')->group(function(){
        Route::get('/' , [AttendanceReportController::class ,'index'])->name('attendance.reports.all');
        Route::get('/data' , [AttendanceReportController::class ,'reports'])->name('attendance.reports.data');
        Route::get('/monthly' , [AttendanceReportController::class ,'index'])->name('attendance.reports.monthly');
        Route::get('/yearly' , [AttendanceReportController::class ,'index'])->name('attendance.reports.yearly');
        Route::get('/edit/{id?}' , [AttendanceReportController::class ,'edit'])->name('attendance.reports.edit');
    });
    Route::prefix('leave/application')->group(function(){
        Route::get('/' , [LeaveController::class ,'index'])->name('leave.application.index');
        Route::get('/create/{id?}' , [LeaveController::class ,'create'])->name('leave.application.create');
        Route::post('/store/{id?}' , [LeaveController::class ,'store'])->name('leave.application.store');
        Route::post('/status' , [LeaveController::class ,'status'])->name('leave.application.status');
        Route::get('/data' , [LeaveController::class ,'data'])->name('leave.application.data');
        Route::get('/monthly' , [LeaveController::class ,'index'])->name('leave.application.monthly');
        Route::get('/yearly' , [LeaveController::class ,'index'])->name('leave.application.yearly');
        Route::get('/details/{id?}' , [LeaveController::class ,'details'])->name('leave.application.details');
        Route::get('/delete/{id?}' , [LeaveController::class ,'delete'])->name('leave.application.delete');
    });
    Route::prefix('notifications')->group(function(){
        Route::get('get_notifications' ,[NotificationController::class , 'notifications'])->name('notifications');
        Route::get('mark/{id?}' ,[NotificationController::class , 'readed'])->name('notifications.marked');
        Route::get('mark/all' ,[NotificationController::class , 'markall'])->name('notifications.marked.all');
    });
    // Generating PDF
    Route::prefix('/pdf')->group(function(){
        Route::get('leave_application/{id}' , [PDFController::class , 'leave_application'])->name('leave.application.pdf');
        Route::get('employee_cv/{id}' , [PDFController::class , 'employee_cv'])->name('employee.cv.pdf');
        Route::POST('attendance_report' , [PDFController::class , 'attendance_report'])->name('employee.attendance.pdf');
    });

    // Settings Route
    Route::prefix('settings/')->group(function(){
        Route::get('create' , [SettingController::class,'create'])->name('settings.create');
        Route::post('store/{id?}' , [SettingController::class,'store'])->name('settings.store');
    });
});
