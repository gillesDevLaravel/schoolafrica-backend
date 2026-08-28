<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

/**
 * Class Matter
 *
 * @property int $id
 * @property string|null $code
 * @property string|null $libelle
 * @property string $name
 * @property bool|null $assessment
 * @property string|null $description
 * @property int|null $idOptionLevel
 * @property int $idSchool
 * @property int $idSection
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Matter extends Model
{
	use SoftDeletes;

	protected $table = 'matter';



	public function levels(){
		return $this->belongsToMany('App\Models\Level','matter_has_level');
	}

	protected $casts = [
		'assessment' => 'bool',
		'idOptionLevel' => 'int',
		'idSchool' => 'int',
		'idSection' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'code',
		'libelle',
		'name',
		'assessment',
		'description',
		'idOptionLevel',
		'idSchool',
		'idSection',
		'created_by',
		'updated_by'
	];

    public function courses()
    {
        return $this->hasMany('App\Models\Course','idMatter');
    }
    public function getGroupForClasse($idClasse)
    {
        $idLevel = Classes::where('id', $idClasse)->value('idLevel');

        return DB::table('matter')
            ->join('matter_group_has_matter', 'matter_group_has_matter.matter_id', '=', 'matter.id')
            ->join('matter_group', 'matter_group.id', '=', 'matter_group_has_matter.matter_group_id')
            ->join('matter_group_has_level', 'matter_group_has_level.matter_group_id', '=', 'matter_group.id')
            ->where('matter.id', $this->id)
            ->where('matter_group_has_level.level_id', $idLevel)
            ->select('matter_group.*')
            ->first();
    }
}
