<?php

namespace App\Http\Controllers;

use App\Http\Resources\ItemResource;
use App\Models\Item;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SignatureController extends Controller
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
                $pattern = '/^((\d+\.)+\d+)/';
                preg_match($pattern, $search, $matches);
                if (count($matches) > 0) {
                    $searchTerm = $matches[1];
                } else {
                    $searchTerm = $search;
                }
                $query->where('signature', 'like', "$searchTerm%");
            }
            $items = $query->with(['category.parent', 'location', 'mediaType'])->orderBy('signature')->get();
        }

        return Inertia::render("Signatures", [
            'itemsResource' =>  ItemResource::collection($items),
        ]);
    }
}
