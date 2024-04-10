<?php

namespace App\Http\Controllers;

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
        return view('website.components.dashboard');
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
}
