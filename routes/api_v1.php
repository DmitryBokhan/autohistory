<?php

use App\Http\Controllers\API\V1\ApiHomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\API\V1\ApiProjectController;



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




//Защишенные маршруты
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/project', [ApiProjectController::class, 'index']);
    Route::get('/project/{id}', [ApiProjectController::class, 'show']);
    Route::get('/project/search/{name}', [ApiProjectController::class, 'search']);
    Route::post('/project', [ApiProjectController::class, 'store']);
    Route::put('/project/{id}', [ApiProjectController::class, 'update']);
    Route::delete('/project/{id}', [ApiProjectController::class, 'destroy']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::put('/project/{id}/add_balance/', [ApiProjectController::class, 'add_balance']); //добавить сумму к текущему балансу

    Route::post('/home', [ApiHomeController::class, 'index']);
});



