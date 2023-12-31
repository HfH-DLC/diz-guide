<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\ItemResource;
use App\Http\Resources\LocationResource;
use App\Http\Resources\MediaTypeResource;
use App\Models\Category;
use App\Models\Item;
use App\Models\Location;
use App\Models\MediaType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class AdminItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Admin/ItemIndex', [
            'itemsResource' => ItemResource::collection(Item::all())
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/ItemCreate', [
            'categoriesResource' => CategoryResource::collection(Category::orderBy('name')->get()),
            'locationsResource' => LocationResource::collection(Location::orderBy('name')->get()),
            'mediaTypesResource' => MediaTypeResource::collection(MediaType::orderBy('name')->get()),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'categoryId' => ['nullable', Rule::exists('categories', 'id')],
            'locationId' => ['required', Rule::exists('locations', 'id')],
            'topic' => ['required', 'string'],
            'mediaTypeId' => ['required', Rule::exists('media_types', 'id')],
            'signature' => ['required', 'string'],
        ]);

        $item = new Item();
        if (isset($validated['categoryId'])) {
            $item->category_id = $validated['categoryId'];
        }
        $item->location_id = $validated['locationId'];
        $item->topic = $validated['topic'];
        $item->media_type_id = $validated['mediaTypeId'];
        $item->signature = $validated['signature'];
        $item->save();
        return to_route('admin.item.show', ['item' => $item]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        return Inertia::render('Admin/ItemShow', [
            'itemResource' => new ItemResource($item),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        return Inertia::render('Admin/ItemEdit', [
            'itemResource' => new ItemResource($item),
            'categoriesResource' => CategoryResource::collection(Category::orderBy('name')->get()),
            'locationsResource' => LocationResource::collection(Location::orderBy('name')->get()),
            'mediaTypesResource' => MediaTypeResource::collection(MediaType::orderBy('name')->get()),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item)
    {
        $validated = $request->validate([
            'categoryId' => ['nullable', Rule::exists('categories', 'id')],
            'locationId' => ['required', Rule::exists('locations', 'id')],
            'topic' => ['required', 'string'],
            'mediaTypeId' => ['required', Rule::exists('media_types', 'id')],
            'signature' => ['required', 'string'],
        ]);

        if (isset($validated['categoryId'])) {
            $item->category_id = $validated['categoryId'];
        }
        $item->location_id = $validated['locationId'];
        $item->topic = $validated['topic'];
        $item->media_type_id = $validated['mediaTypeId'];
        $item->signature = $validated['signature'];
        $item->save();
        return to_route('admin.item.show', ['item' => $item]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        $item->delete();
        return to_route('admin.item.index', ['item' => $item]);
    }
}
