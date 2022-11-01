<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\InvestorResource;
use App\Http\Resources\Api\V1\InvestorCollection;
use App\Models\AppSetting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ApiInvestorController extends Controller
{
    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
    }


    /**
     * Получить инвестора по id
     * @param Request $request
     * @return InvestorResource
     */
    public function getInvestorById(Request $request)
    {
        return new InvestorResource(User::role('investor')->find($request->id));
    }

    /**
     * Получить список всех инвесторов
     * @return InvestorCollection
     */
    public function getInvestors()
    {
        return new InvestorCollection(User::role('investor')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|object
     */
    public function store(Request $request)
    {
        //return $request;
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:password_confirmation',
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $input['invest_percent'] = AppSetting::getDefaultPercentInvest();

        try{
            $user = User::create($input);
        }catch(\Illuminate\Database\QueryException $ex) {
            return response()->json(array('error' => 'Произошла ошибка при создании инвестора'))->setStatusCode(403);

        }
        $user->assignRole('investor');

        return response()->json(array('message' => 'Инвестор успешно создан'))->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
