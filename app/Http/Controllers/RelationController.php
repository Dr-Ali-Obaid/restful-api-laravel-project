<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class RelationController extends Controller
{
    public function lessonTags($id)
    {
        $tags = Lesson::findOrFail($id)->tags;
        $lesson = Lesson::findOrFail($id);
        $fields = array();
        $filteredFields = array();
        foreach($tags as $tag){
            $fields['lesson_title'] = $lesson->title;
            $fields['tag_name'] = $tag->name;
            $filteredFields[] = $fields;
        }
        return response()->json([
            'data' => $filteredFields
        ], 200);
    }

    public function tagLessons($id)
    {
        $lessons = Tag::findOrFail($id)->lessons;
        $tag = Tag::findOrFail($id);
        $fields = array();
        $filteredFields = array();
        foreach($lessons as $lesson){
            $fields['tag_name'] = $tag->name;
            $fields['lesson_title'] = $lesson->title;
            $fields['lesson_body'] = $lesson->body;
            $filteredFields[] = $fields;
        }
        return response()->json([
            'data' => $filteredFields
        ], 200);
    }

    public function userLessons($id)
    {
        $lessons = User::findOrFail($id)->lessons;
        $fields = array();
        $filteredFields = array();
        foreach($lessons as $lesson){
            $fields['user_name'] = $lesson->user->name;
            $fields['lesson_title'] = $lesson->title;
            $fields['lesson_body'] = $lesson->body;
            $filteredFields[] = $fields;
        }
        return response()->json([
            "data" => $filteredFields
        ], 200);
    }
}
