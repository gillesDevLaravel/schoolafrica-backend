<?php

namespace App\Models;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SchoolDelay extends Model
{
    use SoftDeletes;

    // Nom de la table (optionnel si Laravel devine correctement)
    protected $table = 'school_delays';

    // Colonnes autorisées à être remplies en masse
    protected $fillable = ['hour', 'date', 'description', 'type', 'idStudent', 'idCourse', 'created_by', 'updated_by', 'deleted_by',];

    // Relations (si tu as les modèles Student et Course)

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'idStudent');
    }

    public function course(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Course::class, 'idCourse');
    }

    // Relations avec les utilisateurs (si tu as un modèle User)

    public function createdBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deletedBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}
