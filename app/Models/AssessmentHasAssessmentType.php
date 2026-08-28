<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AssessmentHasAssessmentType
 * 
 * @property int $id
 * @property int $assessment_id
 * @property int $assessment_type_id
 *
 * @package App\Models
 */
class AssessmentHasAssessmentType extends Model
{
	protected $table = 'assessments_has_assessment_type';
	public $timestamps = false;

	protected $casts = [
		'assessment_id' => 'int',
		'assessment_type_id' => 'int'
	];

	protected $fillable = [
		'assessment_id',
		'assessment_type_id'
	];
}