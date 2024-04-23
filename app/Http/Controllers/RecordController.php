<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Record;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Exports\RecordExport;




class RecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $records = Record::where('department_index', Auth::user()->department_index);
        if ($request->start_date) {
            $records->where('date', '>', $request->start_date);
        }
        if ($request->end_date) {
            $records->where('date', '<', $request->end_date);
        }
        if ($request->status) {
            $records->where('status', $request->status);
        }
        if ($request->assigned_user_id) {
            $records->where('assigned_user_id', $request->assigned_user_id);
        }
        if ($request->location_id) {
            $records->where('location_id', $request->location_id);
        }
        $records = $records->orderBy('created_at', 'desc')->get();
        $date = Carbon::today()->format('Y_m_d');
        if ($request->excel) {
            return Excel::download(new RecordExport($records), 'Check_in_' . $date . '.xlsx');
        }
        
        $request = $request->all();
        $locations = Location::where('department_index', Auth::user()->department_index)->get();
        $tasks = Task::where('department_index', Auth::user()->department_index)->get();
        $users = User::where('department_index', Auth::user()->department_index)->where('role', 1)->get();
        $today = Carbon::today();

        return view('website.components.records', compact('records', 'locations', 'tasks', 'users', 'today', 'request'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $today = Carbon::now();
        $location = Location::find($request->location_id);
        $task = Task::find($request->task_id);
        $record = new Record();
        $record->location_id = $request->location_id;
        $record->task_id = $request->task_id;
        $record->assigned_user_id = $request->assigned_user_id;
        $record->date = $today;
        if (isset($request->date)) {
            $record->date = $request->date;
        }
        if (isset($task->description)) {
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

    public function myRecords()
    {
        $today = Carbon::today();

        $records = Record::where('assigned_user_id', Auth::user()->id)->orderByRaw("CASE 
        WHEN status = 0 THEN 1
        WHEN status = 2 THEN 2
        ELSE 3 END")
        ->whereDate('date', $today)->get();
        $locations = Location::all();
        $tasks = Task::all();
        $users = User::all();
        $check = 1;
        $checkData = Record::where('assigned_user_id', Auth::user()->id)
            ->whereNotNull('check_in_time')
            ->whereNull('check_out_time')
            ->get();
        $check = $checkData->isEmpty() ? 0 : 1;
        return view('website.components.my_records', compact('records', 'locations', 'tasks', 'users', 'check'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function checkIn(Request $request, $id)
    {
        $record = Record::find($id);
        $currentDateTime = Carbon::now();
        $currentDateTime->addHours(4);
        $record->check_in_time = $currentDateTime;
        $record->number = $request->number;
        $record->position = $request->position;
        $record->responsible_name = $request->responsible_name;

        if ($request->hasfile('image')) {
            $file = $request->file('image');
            $extention = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extention;
            $file->move('assets/image/', $filename);
            $record->image = "assets/image/" . "$filename";
        }
        $record->update();
        return redirect()->back();
    }

    public function checkOut(Request $request, $id)
    {
        $currentDateTime = Carbon::now();
        $currentDateTime->addHours(4);
        $record = Record::find($id);
        $record->status = $request->status;
        $record->check_out_time = $currentDateTime;
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
