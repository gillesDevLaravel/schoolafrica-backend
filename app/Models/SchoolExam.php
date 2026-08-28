<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class SchoolExam extends Model
{
    use SoftDeletes;

    protected $table = 'schools_exams';

    protected $fillable = [
        'name',
        'description',
        'image',
        'answer',
        'idMatter',
        'idAssessmentType',
        'idOptionLevel',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deletedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    /**
     * Relation many-to-many avec les classes via la table pivot
     */
    public function classes(): BelongsToMany
    {
        return $this->belongsToMany(Classes::class, 'school_exam_classe', 'school_exam_id', 'classe_id');
    }
}
