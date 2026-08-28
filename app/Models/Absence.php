<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Absence
 *
 * @property int $id
 * @property string $type
 * @property Carbon|null $date
 * @property int $idCourse
 * @property bool $is_justified
 * @property int|null $idAssessmentType
 * @property int|null $idTeacher
 * @property int|null $idStudent
 * @property int $idSchool
 * @property int|null $idSection
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Absence extends Model
{
    use SoftDeletes;
    
    protected $table = 'absences';

    protected $casts = [
        'idCourse' => 'int',
        'is_justified' => 'bool',
        'idAssessmentType' => 'int',
        'idTeacher' => 'int',
        'idStudent' => 'int',
        'idSchool' => 'int',
        'idSection' => 'int',
        'created_by' => 'int',
        'updated_by' => 'int'
    ];

    protected $dates = [
        'date'
    ];

    protected $fillable = [
        'image',
        'type',
        'date',
        'periode',
        'justification',
        'idCourse',
        'is_justified',
        'idAssessmentType',
        'idTeacher',
        'idStudent',
        'idSchool',
        'idSection',
        'created_by',
        'updated_by'
    ];

    public function notifications()
    {
        return $this->morphMany(Notification::class, 'notificationable');
    }

    public function student()
    {
        return $this->belongsTo(User::class, "idStudent");
    }

    public function course()
    {
        return $this->belongsTo(Course::class, "idCourse");
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, "idTeacher");
    }
}
