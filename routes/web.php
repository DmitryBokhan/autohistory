<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\PositionController;

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

});




Route::post('/cars_ajax', [PositionController::class, 'cars_ajax']);
Route::post('/city_ajax', [PositionController::class, 'city_ajax']);

//временные маршруты для тестирования
Route::get('/create_investor', function () {
    return view('investors.create');
});


Route::get("/test", function(){

    $user = auth()->user();
    dump($user);
    $permissions = $user->getAllPermissions();
    dump($permissions);
   //dd(Auth::user());

   dd($user->hasPermissionTo('role-list'));
});
