<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Api\V1\HomeResource;
use App\Models\User;

class ApiHomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Вернет JSON c данными первого экрана (Home)
        return new HomeResource(User::find(Auth::User()->id));

    }

}
