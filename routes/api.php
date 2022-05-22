<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Models\Project;

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

Route::get('/project', function(){
    return Project::all();
});


Route::post('/project', function(){
    return Project::create([
        'name' => 'Project One',
        'slug' => 'project-one',
        'description' => 'This is project one',
        'balance' => '1000000.00'
    ]);
});
