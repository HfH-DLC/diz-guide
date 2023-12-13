<?php

namespace App\Http\Controllers;

use App\Http\Resources\ItemResource;
use App\Models\Item;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TopicController extends Controller
{

    public function show(Request $request)
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string'],
        ]);

        $items = [];

        if ($request->has('search')) {
            $query = Item::query();
            if (isset($validated['search'])) {
                $search = $validated['search'];
                $query->where('topic', 'like', "%$search%");
            }
            $items = $query->with(['category.parent', 'location', 'mediaType'])->orderBy('topic')->get();
        }

        return Inertia::render("Topics", [
            'itemsResource' =>  ItemResource::collection($items),
        ]);
    }
}
