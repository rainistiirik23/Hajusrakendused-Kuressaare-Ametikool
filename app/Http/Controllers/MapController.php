<?php

namespace App\Http\Controllers;

use App\Models\MapMarker;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MapController extends Controller
{
    public function index()
    {
        $MapMarkers = MapMarker::get();
        return Inertia::render('Map', ['markers' => $MapMarkers]);
    }
    public function store(Request $request)
    {
        MapMarker::create($request->validate([
            'name' => ['required'],
            'description' => ['required'],
            'latitude' => ['required'],
            'longitude' => ['required'],
        ]
        ));
        return redirect()->back();
    }
    public function destroy(Request $request)
    {
        MapMarker::where('id', $request->input('id'))->delete();
        return redirect()->back();
    }
    public function update(Request $request)
    {
        MapMarker::where('id', $request->input('id'))->update($request->validate([
            'name' => ['required'],
            'description' => ['required'],
            'latitude' => ['required'],
            'longitude' => ['required'],
        ]
        ));
        /*  return $request->input(); */
        return redirect()->back();
    }

}
