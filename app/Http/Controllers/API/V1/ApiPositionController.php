<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\Api\V1\PositionCollection;
use App\Http\Resources\Api\V1\PositionDetailResource;
use App\Http\Controllers\Controller;
use App\Models\Position;
use Illuminate\Http\Request;

class ApiPositionController extends Controller
{
    /**
     * Получить коллекцию позиций по ее статусу
     * Статус передается в маршруте
     * Возможные статусы: prepare, sale, archive
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        switch ($request->status){
            case ('prepare'):
                return new PositionCollection(Position::where('position_status_id', 1)->get());
            case ('sale'):
                return new PositionCollection(Position::where('position_status_id', 2)->get());
            case ('archive'):
                return new PositionCollection(Position::where('position_status_id', 3)->get());
            default:
                return ['error' => 'Ошибка. Статус не определен'];
        }
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
        return new PositionDetailResource(Position::find($id));
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
