<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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


Route::resource('project', ProjectController::class);
Route::get('/project/search/{name}', [ProjectController::class, 'search']);


