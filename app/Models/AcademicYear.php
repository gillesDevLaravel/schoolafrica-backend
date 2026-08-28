<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SchoolYear
 *
 * @property int $id
 * @property string $name
 * @property int $idEstablishment
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class AcademicYear extends Model
{
	protected $table = 'academic_years';

	protected $casts = [
		'created_by' => 'int',
        'updated_by' => 'int',
		'deleted_by' => 'int',
	];

	protected $fillable = [
		'name',
		'start_date',
		'end_date',
		'previous_academic_year_id',
		'deleted',
		'deleted_by',
		'created_by',
		'updated_by',
	];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    public function previousAcademicYear()
    {
        return $this->belongsTo(AcademicYear::class, 'previous_academic_year_id');
    }

    public static function getCurrent(): ?self
    {
        return self::where('deleted', false) // facultatif
        ->orderByDesc('id')
            ->first();
    }

    // Dans AcademicYear.php
    public function getLabelAttribute()
    {
        return date('Y', strtotime($this->start_date)) . ' - ' . date('Y', strtotime($this->end_date));
    }

}
