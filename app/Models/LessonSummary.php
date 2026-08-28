<?php

namespace App\Models;

use Google\Service\Classroom\Teacher;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class LessonSummary extends Model
{
    protected $fillable = [
        'idLesson',
        'idTeacher',
        'description',
        'images',
        'date',
        'created_by',
        'deleted',
        'updated_by',
        'deleted_by',
    ];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class, 'idLesson');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'idTeacher');
    }

    /**
     * Get all of the Lesson's Summary images.
     */
    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
