<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LessonTag extends Model
{
     use HasFactory;
    protected $fillable = [
        'lesson_id',
        'tag_id',
    ];
}
