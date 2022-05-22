<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;



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



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});




//-------------Вариант реализации маршрутов---(но мы используем resource вместо этого варианта)
//Получить все проекты
//Route::get('/project', [ProjectController::class, 'index']);

//создать новый проект
//Route::post('/project', [ProjectController::class, 'store']);

//Получить инф о проектt по id
//Route::get('/project/{id}', [ProjectController::class, 'show']);
//---------------------------------------------------------------------------------------------

//----Вариант маршрутизации с ресурс контроллером (для примера)------------------
//не используем тут т.к. нам нужно разделить маршруты на публичные и защищенные
//Route::resource('project', ProjectController::class);
//-------------------------------------------------------------------------------


//Публичные маршруты
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/project', [ProjectController::class, 'index']);
Route::get('/project/{id}', [ProjectController::class, 'show']);
Route::get('/project/search/{name}', [ProjectController::class, 'search']);


//Зашишенные маршруты
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/project', [ProjectController::class, 'store']);
    Route::put('/project/{id}', [ProjectController::class, 'update']);
    Route::delete('/project/{id}', [ProjectController::class, 'destroy']);
    Route::post('/logout', [AuthController::class, 'logout']);

});
