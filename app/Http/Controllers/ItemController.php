<?php

namespace App\Http\Controllers;

use App\Http\Resources\ItemResource;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $validated = $request->validate([
            'search' => ['string'],
            'topic' => [Rule::exists('topics')],
            'location' => [Rule::exists('locations')],
            'mediaType' => [Rule::exists('media_types')],
            'category' => [Rule::exists('categories')],
        ]);

        $items = Item::all();
        return Inertia::render("Items", [
            'itemsResource' =>  ItemResource::collection($items),
        ]);
    }
}
