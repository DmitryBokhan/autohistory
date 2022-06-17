<?php

namespace App\Http\Controllers\API\V1;

use  App\Http\Controllers\Controller;
use App\Models\Project;

use Illuminate\Http\Request;
use App\Http\Requests\ProjectRequest; //в этом классе происходит валидация

class ApiProjectController extends Controller
{

    function __construct()
    {
         $this->middleware('permission:project-list|project-create|project-edit|project-delete', ['only' => ['index','show']]);
         $this->middleware('permission:project-create', ['only' => ['create','store']]);
         $this->middleware('permission:project-edit', ['only' => ['edit','update', 'add_balance']]);
         $this->middleware('permission:project-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Project::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectRequest $request)
    {
        //валидация вынесена в объект ProjectRequest
        // $request->validate([
        //     'name' => 'required',
        //     'slug' => 'required',
        //     'price' => 'required'
        // ])

        return Project::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        return Project::find($id);
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
        $project = Project::find($id);
        $project->update($request->all());
        return $project;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Project::destroy($id);
    }

    /**
     * Search for a name
     *
     * @param  string  $name
     * @return \Illuminate\Http\Response
     */
    public function search($name)
    {
        return Project::where('name', 'like', '%'.$name.'%')->get();
    }

    public function add_balance(Request $request, $id)
    {
        $request->validate([
            'sum' => 'required|regex:/^[0-9]+$/',
        ]);

        $project = Project::find($id);
        $balance = $project->balance += $request->get('sum');
        $project->update(['balence' => $balance]);

        $response = [
            'message' => 'Баланс успешно увеличен'
        ];

        return response($response, 201);

    }
}
