<?php

namespace App\Http\Controllers;

use App\Http\Resources\TopicResource;
use App\Models\Topic;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminTopicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Admin/TopicIndex', [
            'topicsResource' => TopicResource::collection(Topic::orderBy('name')->get())
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/TopicCreate', []);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' => ['required', 'string'],
        ]);

        $topic = new Topic();
        $topic->name = $validated['name'];
        $topic->save();
        return to_route('admin.topic.show', ['topic' => $topic]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Topic $topic)
    {
        return Inertia::render('Admin/TopicShow', [
            'topicResource' => new TopicResource($topic),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Topic $topic)
    {
        return Inertia::render('Admin/TopicEdit', [
            'topicResource' => new TopicResource($topic),
            'categoriesResource' => TopicResource::collection(Topic::all())
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Topic $topic)
    {
        $validated = $request->validate([
            'name' => ['required', 'string'],
        ]);

        $topic->name = $validated['name'];
        $topic->save();
        return to_route('admin.topic.show', ['topic' => $topic]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Topic $topic)
    {
        $topic->delete();
        return to_route('admin.topic.index', ['topic' => $topic]);
    }
}
