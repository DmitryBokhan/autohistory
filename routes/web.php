<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\InvestController;
use App\Http\Controllers\CashOutController;

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
    if(Auth::user()){
        return redirect('/login');
    }else{
        return redirect('/home');
    }
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/panel', function(){
    return view('dashboard.home.index');
});



Route::group(['middleware' => ['auth']], function() {
    //управление пользователями
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);


    Route::resource('projects', ProjectController::class);

    Route::get('/create_position', [PositionController::class, 'create'])->name('create_position');
    Route::post('/create_position', [PositionController::class, 'store'])->name('create_position.store');
    Route::get('/positions', [PositionController::class, 'index'])->name('positions.index');

    Route::get('/position/{position_id}/edit', [PositionController::class, 'edit'])->name('position.edit');

    Route::put('/position/{position_id}', [PositionController::class, 'update'])->name('position.update');

    Route::get("/position_info/{position_id}", [PositionController::class, 'info'])->name('position_info');

    //по этому маршруту мы получаем переменную sale_cost_fact из формы с фиксацией продажи и считаем прибыль исходя из нее, далее фиксируем продажу (кнопка "Подтвердить продажу")
    Route::post("/position_info/{position_id}", [PositionController::class, 'info'])->name('position_info');

    //меняем статус позиции
    Route::post('/position_info/{position_id}/change_status', [PositionController::class, 'change_status'])->name('position_info.change_status');

    //Производим расчеты и переводим в архив
    Route::post('/position_info/{position_id}/position_сlose', [PositionController::class, 'position_close'])->name('position_info.position_close');

    //риход средств
    Route::get('/receipt', [ReceiptController::class, 'index'])->name('receipt.index');
    Route::post('/receipt', [ReceiptController::class, 'store'])->name('receipt.store');

    //вывод средств
    Route::get('/cashout', [CashOutController::class, 'index'])->name('cashout.index');
    Route::post('/cashout', [CashOutController::class, 'store'])->name('cashout.store');

    //страница добавления инвестиции
    Route::get('/invest_position/{position_id}/create',[InvestController::class, 'create'])->name('invest_position.create');

    //добавить инвестицию
    Route::post('/invest_position/store', [InvestController::class, 'store'])->name('invest_position.store');

    Route::post('/invest_position/account/{account_id}/delete', [InvestController::class, 'delete'])->name('invest_position.account_delete');

});




Route::post('/cars_ajax', [PositionController::class, 'cars_ajax']);
Route::post('/city_ajax', [PositionController::class, 'city_ajax']);

//временные маршруты для тестирования
Route::get('/create_investor', function () {
    return view('investors.create');
});


Route::get("/test", function(){

    $position = App\Models\Position::find(4);
    dd($position->user->name);

   // dd(User::role('investor')->get());
    $user = auth()->user();
    dump($user);
    $permissions = $user->getAllPermissions();
    dump($permissions);
   //dd(Auth::user());

   dd($user->hasPermissionTo('role-list'));
});
