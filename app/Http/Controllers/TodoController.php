<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todos;

class TodoController extends Controller
{
    public function index()
    {
        return Todos::all();
        // return response()->json(Todos::all());
    }
    

    public function store(Request $request)
{
    $validated = $request->validate([
        'task' => 'required|string|max:255',
        'description' => 'required|string|max:255', 
        'status' => 'required|in:Active,Inactive',
    ]);

    $todo = Todos::create([
        'task' => $validated['task'],
        'description' => $validated['description'],
        'status' => $validated['status'],
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return response()->json($todo, 201); 
}

    public function show($id)
    {
        $todo=Todos::find($id);
        if (!empty($todo)) 
        {
            return response()->json($todo);
        }
        else
         {
            return response()->json([
                "message"=>"Todo not found"
            ],404);
        }
    }
    public function update(Request $request,$id)
    {

        $todo=Todos::find($id);
        if(Todos::where('id',$id)->exists())
        {
           
            $todo->task=is_null($request->task)?$todo->task:$request->task;
            $todo->description=is_null($request->description)?$todo->description:$request->description;
            $todo->status=is_null($request->status)?$todo->status:$request->status;
            $todo->save();
            return response()->json([
                "message"=>"Todo Updated",
                "todo"=>$todo
            ],201);
        }
        else
        {
            return response()->json([
                "message"=>"Todo not found"
            ],404);
        }
    }
    public function destroy($id)
    {
        if(Todos::where('id',$id)->exists())
        {
            $todo=Todos::find($id);
            $todo->delete();
            return response()->json([
                "message"=>"records deleted"
            ],202);
        }
        else
        {
            return response()->json([
                "message"=>"Todo not found"
            ],404);
        }
    }
    
}
