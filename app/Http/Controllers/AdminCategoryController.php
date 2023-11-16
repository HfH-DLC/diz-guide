<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class AdminCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Admin/CategoryIndex', [
            'categoriesResource' => CategoryResource::collection(Category::where('parent_id', null)->orderBy('name')->get())
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/CategoryCreate', [
            'categoriesResource' => CategoryResource::collection(Category::where('parent_id', null)->orderBy('name')->get())
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string'],
            'parentId' => ['nullable', Rule::exists(Category::class, 'id')],
        ]);
        $category = new Category();
        $category->name = $validated['name'];
        if (isset($validated['parentId'])) {
            $category->parent_id = $validated['parentId'];
        }
        $category->save();
        return to_route('admin.category.show', ['category' => $category]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $category->load('parent');
        return Inertia::render('Admin/CategoryShow', [
            'categoryResource' => new CategoryResource($category),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $category->load('parent');
        return Inertia::render('Admin/CategoryEdit', [
            'categoryResource' => new CategoryResource($category),
            'categoriesResource' => CategoryResource::collection(Category::whereNot('id', $category->id)->where('parent_id', null)->get()),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => ['required', 'string'],
            'parentId' => ['nullable', Rule::exists(Category::class, 'id')],
        ]);
        $category->name = $validated['name'];
        if (isset($validated['parentId'])) {
            $category->parent_id = $validated['parentId'];
        }
        $category->save();
        return to_route('admin.category.show', ['category' => $category]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->back();
    }
}
