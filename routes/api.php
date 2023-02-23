<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MemberController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register']);

Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::get('/data-member',[MemberController::class, 'data_member']);
    Route::post('/member-add',[MemberController::class, 'member_add']);
    Route::post('/member-detail',[MemberController::class, 'member_detail']);
    Route::post('/member-update',[MemberController::class, 'member_update']);
    Route::post('/member-delete',[MemberController::class, 'member_delete']);
    Route::get('/logout',[AuthController::class, 'logout']);
});