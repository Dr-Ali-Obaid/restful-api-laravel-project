<?php

namespace App\Http\Controllers;

use App\Http\Resources\TagResource;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $limit = $request->input('limit');
        $limit = ($limit > 10) ? 10 : $limit;
        $tags = TagResource::collection(Tag::paginate($limit));
        return $tags->response()->setStatusCode(200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Tag::clss);
        $tag = Tag::create($request->all());
        return (new TagResource($tag))
        ->additional(["message" => "the tag created successfully"])
        ->response()->setStatusCode(200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $tag = new TagResource(Tag::with('lessons')->findOrFail($id));
        return $tag->response()->setStatusCode(200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $tag = Tag::findOrFail($id);
        $this->authorize('update', $tag);
        $tag->update($request->all());
        return (new TagResource($tag))
        ->additional(["message" => "The Tag Updated Successfully"])
        ->response()->setStatusCode(200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $tag = Tag::findOrFail($id);
        $this->authorize("delete", $tag);
        $tag->delete();
        return response(["message" => "the tag deleted successfully"]);
    }
}
