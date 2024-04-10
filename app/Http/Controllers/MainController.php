<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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
        $users = User::all();
        return view('website.components.users', compact('users'));
    }

    public function usersUpdate(Request $request, $id)
    {   
        $user = User::find($id);
        $user->role = $request->role;
        $user->update();
        return redirect()->back();
    }
}
