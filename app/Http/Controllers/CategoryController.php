<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\ItemResource;

use App\Http\Resources\MediaTypeResource;
use App\Models\Category;
use App\Models\Item;
use App\Models\MediaType;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function show(Request $request)
    {
        $validated = $request->validate([
            'mediaTypeIds' => ['nullable', 'array'],
            'mediaTypeIds.*' => ['numeric', 'integer'],
            'categoryIds' =>  ['nullable', 'array'],
            'categoryIds.*' => ['numeric', 'integer'],
        ]);

        $query = Item::query();

        $categoryIds = [];
        $mediaTypeIds = [];

        if (isset($validated['categoryIds'])) {
            $categoryIds = $validated['categoryIds'];
        }
        if (isset($validated['mediaTypeIds'])) {
            $mediaTypeIds = $validated['mediaTypeIds'];
        }

        $query->where(function ($query) use ($categoryIds) {
            $query->whereIn('category_id', $categoryIds)->orWhere('category_id', null);
        });
        $query->whereIn('media_type_id', $mediaTypeIds);

        $items = [];

        if (isset($validated['categoryIds']) || isset($validated['mediaTypeIds'])) {
            $items = $query->with(['category.parent', 'location', 'mediaType'])->get();
            $items  = $items->sortBy(function ($item) {
                if ($item->category) {
                    return $item->category->name;
                }
                return "";
            });
        }

        return Inertia::render("Categories", [
            'itemsResource' =>  ItemResource::collection($items),
            'categoriesResource' => CategoryResource::collection(Category::where('parent_id', null)->with('children')->orderBy('name')->get()),
            'mediaTypesResource' => MediaTypeResource::collection(MediaType::orderBy('name')->get()),
        ]);
    }
}
