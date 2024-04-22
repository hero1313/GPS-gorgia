<?php

namespace App\Http\Controllers;

use App\Models\Record;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function dashboard()
    {
        $firstDateOfLastMonth = now()->subMonth()->startOfMonth();
        $today = now();
        $records = Record::where('department_index', Auth::user()->department_index);

        $lastMonthRecords = $records->where('date', '>', $firstDateOfLastMonth)->count();
        $successRecords = $records->where('status', '=', 1)->count();
        $failedRecords = $records->where('status', '=', 1)->count();
        $todayCount = $records->where('status', 1)->whereDate('date', '=', $today)->count();
        $totalCount = $records->whereDate('date', '=', $today)->count();

        $pieSuccess = $records->where('status', '=', 1)->whereDate('date', '=', $today)->count();
        $pieFailed = $records->where('status', '=', 2)->whereDate('date', '=', $today)->count();
        $pieActive = $records->where('status', '=', 0)->whereDate('date', '=', $today)->count();
        $pieData = [$pieSuccess, $pieFailed, $pieActive];
        $todayPercentage = $totalCount != 0 ? ($todayCount / $totalCount) * 100 : 0;


        // dd($lastMonthRecords);

        return view('website.components.dashboard', compact('lastMonthRecords', 'successRecords', 'failedRecords', 'todayPercentage', 'pieData'));
    }

    /**
     * Display a listing of the resource.
     */
    public function users()
    {
        $users = User::where('department_index', Auth::user()->department_index)->get();
        return view('website.components.users', compact('users'));
    }

    public function usersUpdate(Request $request, $id)
    {   
        $user = User::find($id);
        $user->role = $request->role;
        $user->update();
        return redirect()->back();
    }

    public function usersDestroy($id)
    {   
        $user = User::find($id);
        $user->delete();
        return redirect()->back();
    }
    public function redirect()
    {   
        $role = Auth::user()->role ;
        if($role == 2){
            return redirect('/locations');
        }
        else if($role == 1){
            return redirect('/my-records');
        }
        else{
            return redirect('/my-records');
        }
    }
}
