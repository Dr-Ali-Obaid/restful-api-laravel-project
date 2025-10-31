<?php

namespace App\Http\Controllers;

use App\Http\Resources\LessonResource;
use App\Models\Lesson;
use Illuminate\Http\Request;

class LessonController extends Controller
{
     public function __construct(){
        $this->middleware('auth:sanctum')->except(['index']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $limit = $request->input('limit');
        $limit = ($limit > 20) ? 20 : $limit;
        $lessons = LessonResource::collection(Lesson::paginate($limit));

        
        return $lessons->response()->setStatusCode(200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $lesson = new LessonResource(Lesson::create($request->all()));
        return $lesson->response()->setStatusCode(200, ' The Lesson Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $lesson = new LessonResource(Lesson::with('tags')->findOrfail($id));
        return $lesson->response()->setStatusCode(200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $lesson = Lesson::findOrFail($id);
        $this->authorize('update', $lesson);
        $lesson->update($request->all());
        return (new LessonResource($lesson))
            ->additional(["message" => "the lesson updated successfully"])
            ->response()->setStatusCode(200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $lesson = Lesson::findOrFail($id);
        $this->authorize('delete', $lesson);
        $lesson->delete();
        return response(['message' => "the lesson deleted successfully"], 201);
    }
}
