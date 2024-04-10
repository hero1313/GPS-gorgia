<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::all();
        return view('website.components.tasks', compact('tasks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $task = new Task();
        $task->name = $request->name;
        $task->description = $request->description;
        $task->department_index = Auth::user()->department_index;
        $task->save();
        return redirect()->back();

    }

    /**
     * Store a newly created resource in storage.
     */
    public function update(Request $request, $id)
    {   
        $task = Task::find($id);
        $task->name = $request->name;
        $task->description = $request->description;
        
        $task->update();
        return redirect()->back();

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $task = Task::find($id);
        $task->delete();
        return redirect()->back();

    }
}
