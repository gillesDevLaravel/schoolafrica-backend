<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AssessmentHasTypeEvaluation
 * 
 * @property int $id
 * @property int $assessment_id
 * @property int $type_evaluation_id
 *
 * @package App\Models
 */
class AssessmentHasTypeEvaluation extends Model
{
	protected $table = 'assessments_has_type_evaluation';
	public $timestamps = false;

	protected $casts = [
		'assessment_id' => 'int',
		'type_evaluation_id' => 'int'
	];

	protected $fillable = [
		'assessment_id',
		'type_evaluation_id'
	];
}