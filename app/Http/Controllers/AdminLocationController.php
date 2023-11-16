<?php

namespace App\Http\Controllers;

use App\Http\Resources\LocationResource;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class AdminLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Admin/LocationIndex', [
            'locationsResource' => LocationResource::collection(Location::orderBy('name')->get())
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/LocationCreate', []);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' => ['required', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg'],
            'imageAlt' =>  ['nullable', 'string'],
        ]);

        $location = new Location();
        $location->name = $validated['name'];

        if (isset($validated['image'])) {
            $fileName = time() . '.' . $request->image->extension();
            $request->image->storeAs('public/images', $fileName);
            $location->image_src = $fileName;
        }
        if (isset($validated['imageAlt'])) {
            $location->image_alt = $validated['imageAlt'];
        }
        $location->save();
        return to_route('admin.location.show', ['location' => $location]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Location $location)
    {
        return Inertia::render('Admin/LocationShow', [
            'locationResource' => new LocationResource($location),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Location $location)
    {
        return Inertia::render('Admin/LocationEdit', [
            'locationResource' => new LocationResource($location),
            'categoriesResource' => LocationResource::collection(Location::all())
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Location $location)
    {
        $validated = $request->validate([
            'name' => ['required', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg'],
            'imageAlt' =>  ['nullable', 'string'],
        ]);

        $location->name = $validated['name'];
        if (isset($validated['image'])) {
            $fileName = time() . '.' . $request->image->extension();
            $request->image->storeAs('public/images', $fileName);
            $location->image_src = $fileName;
        }
        if (isset($validated['imageAlt'])) {
            $location->image_alt = $validated['imageAlt'];
        }
        $location->save();
        return to_route('admin.location.show', ['location' => $location]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Location $location)
    {
        Storage::disk('public')->delete("/images/$location->image_src");
        $location->delete();
        return to_route('admin.location.index');
    }
}
