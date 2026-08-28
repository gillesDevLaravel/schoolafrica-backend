<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ScanReceipt extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'idAcademicYear',
        'idSchool',
        'idStudent',
        'image_scan',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class, 'idAcademicYear');
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class, 'idSchool');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'idStudent');
    }
}
