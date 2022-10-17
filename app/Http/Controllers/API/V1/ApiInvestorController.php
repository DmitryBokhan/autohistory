<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\InvestorResource;
use App\Http\Resources\Api\V1\InvestorCollection;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Account;

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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
