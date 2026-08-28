<?php

namespace App;

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ExamensStudents
 *
 * @property int $id
 * @property int $idAssessment
 * @property int $idUser
 * @property int $idAssessmentType
 * @property int $statut
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * @property int|null $deleted
 *
 * @package App\Models
 */
class ExamStudent extends Model
{
    protected $table = 'exam_students';

    protected $fillable = [
        'idAssessment',
        'idAssessmentType',
        'idUser',
        'statut',
        'finished',
        'updated_by',
        'deleted_by',
        'deleted'
    ];

    public function assessment()
    {
        return $this->belongsTo(Assessment::class, 'idAssessment', 'id');
    }

    public function assessmentType()
    {
        return $this->belongsTo(AssessmentType::class, 'idAssessmentType', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'idUser', 'id');
    }

    public function scopeNotDeleted($query)
    {
        return $query->where('deleted', 0);
    }

    // Mutateur pour le champ statut
    public function setStatutAttribute($value)
    {
        $this->attributes['statut'] = $value ? "valid" : "invalid";  // Assurez-vous que le statut est toujours 0 ou 1
    }
}
