<?php

use App\Http\Controllers\WebController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\StudentsController;
use App\Http\Controllers\MomentController;
use App\Http\Controllers\BiserialController;
use App\Http\Controllers\UjiAnavaController;
use App\Http\Controllers\UjiTController;
use App\Models\UjiT;
use Illuminate\Support\Facades\Route;

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

//root



Route::get('/', function () {
    return view('layout.template');

});



Route::get('/', [WebController:: class,'home']); //route "/" memanggil webcontroller dgn method home

Route::get('/about',[WebController:: class,'about']); //route "/about" memanggil webcontroller dgn method about

Route::get('/mahasiswa', [MahasiswaController:: class,'index']); //route "/mahasiswa" memanggil mahasiswacontroller dgn method index

//students
Route::get('/students', [StudentsController:: class,'index']);
Route::get('/students/create', [StudentsController:: class,'create']);
Route::get('/students/{student}', [StudentsController:: class,'show']);
Route::post('/students', [StudentsController:: class,'store']);
Route::delete('/students/{student}', [StudentsController::class,'destroy']);
Route::get('/students/{student}/edit', [StudentsController::class,'edit']);
Route::PATCH('/students/{student}',[StudentsController::class,'update']);
Route::get('/exportstudents',[StudentsController::class,'studentsexport']); //export nilai
Route::post('/mahasiswa/importstudents',[StudentsController::class,'studentsimportexcel']);//importnilai

Route::get('/databergolong',[MahasiswaController::class,'databergolong']);

Route::get('/chikuadrat',[MahasiswaController::class,'chikuadrat']);

Route::get('/lilliefors',[MahasiswaController::class,'lilliefors']);

Route::get('/korelasiMoment',[MomentController::class,'korelasiMoment']); //product moment
Route::get('/exportmoment',[MomentController::class,'exportmoment']); //export moment
Route::post('/importmoment',[MomentController::class,'importmoment']); //import moment
Route::get('/createmoment',[MomentController::class,'create']);
Route::post('/korelasiMoment',[MomentController::class,'store']);
Route::delete('/hapusmoment/{id}',[MomentController::class,'deleteMoment']);

Route::get('/korelasiBiserial',[BiserialController::class,'korelasiBiserial']); //point biserial
Route::get('/exportbiserial',[BiserialController::class,'exportbiserial']);//export biserial
Route::post('/importbiserial',[BiserialController::class,'importbiserial']); //import  biserial
Route::get('/createbiserial',[BiserialController::class,'create']);
Route::post('/korelasiBiserial',[BiserialController::class,'store']);
Route::delete('/hapusbiserial/{id}',[BiserialController::class,'deleteBiserial']);

Route::get('/ujiTBerkorelasi',[UjiTController::class,'ujiTBerkorelasi']);//data uji T
Route::get('/exportujiT',[UjiTController::class,'ujiTBerkorelasiExport']);//EXPORT UJI T
Route::post('/importujiT',[UjiTController::class,'ujiTBerkorelasiImport']);// IMPORT UJI T
Route::get('/createujiT',[UjiTController::class,'create']);
Route::post('/ujiTBerkorelasi',[UjiTController::class,'store']);
Route::delete('/hapus/{id}',[UjiTController::class,'deleteT']);



Route::get('/ujiAnava',[UjiAnavaController::class,'ujiAnava']); //uji anava
Route::get('/exportAnava',[UjiAnavaController::class,'exportAnava']); //EXPORT ANAVA
Route::post('/importAnava',[UjiAnavaController::class,'importAnava']); //importanava
Route::get('/createujiAnava',[UjiAnavaController::class,'create']);
Route::post('/ujiAnava',[UjiAnavaController::class,'store']);
Route::delete('/deleteanava/{id}',[UjiAnavaController::class,'deleteAnava']);


