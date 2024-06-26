<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $locations = Location::where('department_index', Auth::user()->department_index);
        if ($request->search) {
            $locations->where('name', 'LIKE', "%{$request->search}%")
            ->orWhere('city', 'LIKE', "%{$request->search}%");
        }
        $locations = $locations->orderBy('created_at', 'desc')->get();
        $request = $request->all();

        return view('website.components.locations', compact('locations','request'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $location = new Location();
        $location->name = $request->name;
        $location->city = $request->city;
        $location->lat = $request->lat;
        $location->lng = $request->lng;
        $location->owner = $request->owner;
        $location->owner_number = $request->owner_number;
        $location->radius = $request->radius;
        $location->timer = $request->timer;
        $location->description = $request->description;
        $location->department_index = Auth::user()->department_index;

        $location->save();
        return redirect()->back();

    }

    /**
     * Store a newly created resource in storage.
     */
    public function update(Request $request, $id)
    {   
        $location = Location::find($id);
        $location->name = $request->name;
        $location->city = $request->city;
        $location->lat = $request->lat;
        $location->lng = $request->lng;
        $location->description = $request->description;
        $location->owner = $request->owner;
        $location->owner_number = $request->owner_number;
        $location->radius = $request->radius;
        $location->timer = $request->timer;
        
        $location->update();
        return redirect()->back();

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $location = Location::find($id);
        $location->delete();
        return redirect()->back();

    }
}
