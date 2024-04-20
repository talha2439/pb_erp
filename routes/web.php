<?php

use App\Http\Controllers\Admin\{Dashboardcontroller, MenuAccessController, MenuSettingController, UserAccessController, UserController};
use App\Http\Controllers\AuthController;
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

Route::prefix('/panel')->middleware('auth')->group(function(){
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

});
