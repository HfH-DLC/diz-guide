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
use Inertia\Inertia;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string'],
            'locationIds' =>  ['nullable', 'array'],
            'locationIds.*' => ['numeric', 'integer'],
            'mediaTypeIds' => ['nullable', 'array'],
            'mediaTypeIds.*' => ['numeric', 'integer'],
            'categoryIds' =>  ['nullable', 'array'],
            'categoryIds.*' => ['numeric', 'integer'],
        ]);

        $query = Item::query();
        if (isset($validated['search'])) {
            $search = $validated['search'];
            $query->where('topic', 'like', "%$search%");
        }
        if (isset($validated['categoryIds'])) {
            $query->where(function ($query) use ($validated) {
                $query->whereIn('category_id', $validated['categoryIds'])->orWhere('category_id', null);
            });
        }
        if (isset($validated['locationIds'])) {
            $query->whereIn('location_id', $validated['locationIds']);
        }
        if (isset($validated['mediaTypeIds'])) {
            $query->whereIn('media_type_id', $validated['mediaTypeIds']);
        }

        $items = $query->with('category.parent')->get();

        return Inertia::render("Items", [
            'itemsResource' =>  ItemResource::collection($items),
            'categoriesResource' => CategoryResource::collection(Category::where('parent_id', null)->orderBy('name')->get()),
            'locationsResource' => LocationResource::collection(Location::orderBy('name')->get()),
            'mediaTypesResource' => MediaTypeResource::collection(MediaType::orderBy('name')->get()),
        ]);
    }
}
