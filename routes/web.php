<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AdminController;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PaymentExport;
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

Route::get('/', function(){
    return view("login");
})->name("login");
Route::post('/', [LoginController::class,'login']);
Route::get('/logout', function(Request $request){
    $request->session()->flush();
    return redirect('/');
})->name("login");
Route::group(['prefix'=>'student'] , function() {
    //學生主頁
    Route::get('/' , [StudentController::class, 'index'])->name("student");
    //加選課程
    Route::get('/add_CS' , [StudentController::class, 'add_CS'])->name("add_CS");
    Route::post('/add_CS' , [StudentController::class, 'add_submit']);
    //退選課程
    Route::get('/drop_CS', [StudentController::class, 'drop_CS'])->name("drop_CS");
    Route::post('/drop_CS', [StudentController::class, 'drop_submit']);
});

Route::group(['prefix'=>'admin'] , function() {
    //教師主頁
    Route::get('/' , [AdminController::class, 'index'])->name("admin");
    Route::post('/' , [AdminController::class, 'search']);
    //課程管理
    Route::get('/Course', [AdminController::class, 'Course'])->name("Course");
    Route::post('/Course', [AdminController::class, 'Course_search']);
    Route::post('/Course_origin', [AdminController::class, 'Course_origin']);
    Route::post('/Course_update', [AdminController::class, 'Course_update']);
    Route::post('/Course_drop', [AdminController::class, 'Course_drop']);
    //學籍管理
    Route::get('/SchoolRoll', [AdminController::class, 'SchoolRoll'])->name("SchoolRoll");
    Route::post('/SchoolRoll', [AdminController::class, 'SchoolRoll_search']);
    Route::post('/SchoolRoll_origin', [AdminController::class, 'SchoolRoll_origin']);
    Route::post('/SchoolRoll_update', [AdminController::class, 'SchoolRoll_update']);
    Route::post('/SchoolRoll_drop', [AdminController::class, 'SchoolRoll_drop']);
    //科系管理
    Route::get('/Department', [AdminController::class, 'Department'])->name("Department");
    Route::post('/Department', [AdminController::class, 'Department_search']);
    Route::post('/Department_origin', [AdminController::class, 'Department_origin']);
    Route::post('/Department_update', [AdminController::class, 'Department_update']);
    Route::post('/Department_drop', [AdminController::class, 'Department_drop']);
});
