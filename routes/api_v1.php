<?php

use App\Http\Controllers\API\V1\ApiCarsBaseController;
use App\Http\Controllers\API\V1\ApiCityController;
use App\Http\Controllers\API\V1\ApiHomeController;
use App\Http\Controllers\Api\V1\ApiInvestorController;
use App\Http\Controllers\Api\V1\ApiInvestController;
use App\Http\Controllers\Api\V1\ApiPositionController;
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

    //HOME Главный экран приложения
    Route::post('/home', [ApiHomeController::class, 'index']); //Данные для главного экрана приложения

    //Раздел ИНВЕСТОРЫ
    Route::get('/investors/{id}', [ApiInvestorController::class, 'getInvestorById']); //Инф-я о конкретном инвесторе (пока маршрут нигде не используется)
    Route::get('/investors', [ApiInvestorController::class, 'getInvestors']); //Инф-я о всех инвесторах для раздела Инвесторы->Инвесторы (список инвесторов)

    //Раздел Позиции
    Route::get('/position/{id}', [ApiPositionController::class, 'show']); //данные о позиции (детальная информация)
    Route::get('/position/{status}/list', [ApiPositionController::class, 'index']); //status: prepare, sale, archive | получить список позиций определенного статуса
    Route::post('/position/store', [ApiPositionController::class, 'store']);//добавить новую позицию
    Route::put('/position/{id}', [ApiPositionController::class, 'update']);//бновить данные позиции

    //Инвестиции в позицию
    Route::get('/invest_position/{id}', [ApiInvestController::class, 'index']); //данный для формы "Инвестиция в позицию"
    

    //Запросы в базу автомобилей (carsbase)
    Route::prefix('carsbase')->group(function(){
        Route::get('/marks', [ApiCarsBaseController::class, 'marks']); //получить список марок
        Route::post('/models', [ApiCarsBaseController::class, 'models']); //получить список марок по моделе
        Route::post('/engines', [ApiCarsBaseController::class, 'engines']); //получить список типов двигателей
        Route::post('/volumes', [ApiCarsBaseController::class, 'volumes']); //получить список объемов двигателей
        Route::post('/transmissions', [ApiCarsBaseController::class, 'transmissions']); //получить список объемов двигателей
        Route::post('/car_id', [ApiCarsBaseController::class, 'getCarId']); //получить id автомобиля
    });

    //Заросы в базы Стран (countries), Регионов (regions), Городов(cities)
    Route::prefix('city')->group(function(){
        Route::get('/countries', [ApiCityController::class, 'countries']); //получить список стран
        Route::post('/regions', [ApiCityController::class, 'regions']); //получить список регионов в стране
        Route::post('/cities', [ApiCityController::class, 'cities']); //получить список городов в регионе
        Route::post('/city_id',[ApiCityController::class, 'getCityId']); //получить id города
    });
});





