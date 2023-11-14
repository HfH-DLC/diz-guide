<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\ItemResource;
use App\Http\Resources\LocationResource;
use App\Http\Resources\MediaTypeResource;
use App\Http\Resources\TopicResource;
use App\Models\Category;
use App\Models\Item;
use App\Models\Location;
use App\Models\MediaType;
use App\Models\Topic;
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
            'categoriesResource' => CategoryResource::collection(Category::all()),
            'locationsResource' => LocationResource::collection(Location::all()),
            'topicsResource' => TopicResource::collection(Topic::all()),
            'mediaTypesResource' => MediaTypeResource::collection(MediaType::all()),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'categoryId' => ['required', Rule::exists('categories', 'id')],
            'locationId' => ['required', Rule::exists('locations', 'id')],
            'topicId' => ['required', Rule::exists('topics', 'id')],
            'mediaTypeId' => ['required', Rule::exists('media_types', 'id')],
            'signature' => ['required', 'string'],
        ]);

        $item = new Item();
        $item->category_id = $validated['categoryId'];
        $item->location_id = $validated['locationId'];
        $item->topic_id = $validated['topicId'];
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
            'categoriesResource' => CategoryResource::collection(Category::all()),
            'locationsResource' => LocationResource::collection(Location::all()),
            'topicsResource' => TopicResource::collection(Topic::all()),
            'mediaTypesResource' => MediaTypeResource::collection(MediaType::all()),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item)
    {
        $validated = $request->validate([
            'categoryId' => ['required', Rule::exists('categories', 'id')],
            'locationId' => ['required', Rule::exists('locations', 'id')],
            'topicId' => ['required', Rule::exists('topics', 'id')],
            'mediaTypeId' => ['required', Rule::exists('media_types', 'id')],
            'signature' => ['required', 'string'],
        ]);

        $item->category_id = $validated['categoryId'];
        $item->location_id = $validated['locationId'];
        $item->topic_id = $validated['topicId'];
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
