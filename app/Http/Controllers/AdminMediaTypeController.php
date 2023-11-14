<?php

namespace App\Http\Controllers;

use App\Http\Resources\MediaTypeResource;
use App\Models\MediaType;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminMediaTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Admin/MediaTypeIndex', [
            'mediaTypesResource' => MediaTypeResource::collection(MediaType::orderBy('name')->get())
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/MediaTypeCreate', []);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' => ['required', 'string'],
        ]);

        $mediaType = new MediaType();
        $mediaType->name = $validated['name'];
        $mediaType->save();
        return to_route('admin.media-type.show', ['mediaType' => $mediaType]);
    }

    /**
     * Display the specified resource.
     */
    public function show(MediaType $mediaType)
    {
        return Inertia::render('Admin/MediaTypeShow', [
            'mediaTypeResource' => new MediaTypeResource($mediaType),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MediaType $mediaType)
    {
        return Inertia::render('Admin/MediaTypeEdit', [
            'mediaTypeResource' => new MediaTypeResource($mediaType),
            'categoriesResource' => MediaTypeResource::collection(MediaType::all())
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MediaType $mediaType)
    {
        $validated = $request->validate([
            'name' => ['required', 'string'],
        ]);

        $mediaType->name = $validated['name'];
        $mediaType->save();
        return to_route('admin.media-type.show', ['mediaType' => $mediaType]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MediaType $mediaType)
    {
        $mediaType->delete();
        return to_route('admin.media-type.index', ['mediaType' => $mediaType]);
    }
}
