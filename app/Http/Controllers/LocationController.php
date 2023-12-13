<?php

namespace App\Http\Controllers;

use App\Http\Resources\ItemResource;
use App\Http\Resources\LocationResource;
use App\Models\Item;
use App\Models\Location;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LocationController extends Controller
{
    public function show(Request $request)
    {
        $validated = $request->validate([
            'locationIds' =>  ['nullable', 'array'],
            'locationIds.*' => ['numeric', 'integer'],
        ]);

        $items = [];
        if (isset($validated['locationIds'])) {
            $query = Item::query();
            $locationIds = $validated['locationIds'];
            $query->where(function ($query) use ($locationIds) {
                $query->whereIn('location_id', $locationIds)->orWhere('location_id', null);
            });
            $items = $query->with(['category.parent', 'location', 'mediaType'])
                ->join('locations', 'locations.id', '=', 'items.location_id')
                ->orderBy('locations.name')
                ->select('items.*')
                ->get();
        }

        return Inertia::render("Locations", [
            'itemsResource' =>  ItemResource::collection($items),
            'locationsResource' => LocationResource::collection(Location::orderBy('name')->get()),
        ]);
    }
}
