<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Record;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class RecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $records = Record::where('department_index', Auth::user()->department_index)->get();
        $locations = Location::where('department_index', Auth::user()->department_index)->get();
        $tasks = Task::where('department_index', Auth::user()->department_index)->get();
        $users = User::where('department_index', Auth::user()->department_index)->where('role', 1)->get();
        $today = Carbon::today();

        return view('website.components.records', compact('records', 'locations', 'tasks', 'users', 'today'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $location = Location::find($request->location_id);
        $task = Task::find($request->task_id);
        $record = new Record();
        $record->location_id = $request->location_id;
        $record->task_id = $request->task_id;
        $record->assigned_user_id = $request->assigned_user_id;
        $record->date = $request->date;
        if(isset($task->description)){
            $record->description = $task->description;
        }
        $record->department_index = Auth::user()->department_index;
        $record->lat = $location->lat;
        $record->lng = $location->lng;
        $record->radius = $location->radius;
        $record->timer = $location->timer;
        $record->status = 0;

        $record->save();

        return redirect()->back();

    }

    /**
     * Store a newly created resource in storage.
     */
    public function update(Request $request, $id)
    {   
        $location = Location::find($request->location_id);
        $task = Task::find($request->task_id);
        $record = Record::find($id);
        
        $record->location_id = $request->location_id;
        $record->task_id = $request->task_id;
        $record->assigned_user_id = $request->assigned_user_id;
        $record->date = $request->date;
        $record->description = $task->description;
        $record->lat = $location->lat;
        $record->lng = $location->lng;
        $record->radius = $location->radius;
        $record->timer = $location->timer;
        $record->update();
        return redirect()->back();

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $record = Record::find($id);
        $record->delete();
        return redirect()->back();

    }


    // my records

    public function myRecords ()
    {
        $records = Record::all();
        $locations = Location::all();
        $tasks = Task::all();
        $users = User::all();

        return view('website.components.my_records', compact('records', 'locations', 'tasks', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function checkIn(Request $request, $id)
    {   
        $record = Record::find($id);
        $record->check_in_time = $request->check_in_time;
        if ($request->hasfile('image')) {
            $file = $request->file('image');
            $extention = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extention;
            $file->move('assets/image/', $filename);
            $record->image = "assets/image/"."$filename";
        }
        $record->update();
        return redirect()->back();

    }

    public function checkOut(Request $request, $id)
    {   
        $record = Record::find($id);
        $record->status = $request->status;
        $record->check_out_time = $request->check_out_time;
        $record->comment = $request->comment;
        $record->update();
        return redirect()->back();

    }

    public function comment(Request $request, $id)
    {   
        $record = Record::find($id);
        $record->comment = $request->comment;
        $record->update();
        return redirect()->back();

    }
}
