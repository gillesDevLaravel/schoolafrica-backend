<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class SchoolSupply
 *
 * @property int $id
 * @property string $supply
 * @property int $idLevel
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
class SchoolSupply extends Model
{
	protected $table = 'school_supply';

	protected $casts = [
		'idLevel' => 'int',
		'idOptionLevel' => 'int',
		'idSchool' => 'int',
		'idSection' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'image',
		'description',
		'supply',
		'idLevel',
		'idOptionLevel',
		'idSchool',
		'idSection',
		'created_by',
		'updated_by'
	];

    public function classes(): BelongsToMany
    {
        return $this->belongsToMany(Classes::class, 'classe_school_supply', 'school_supply_id', 'classe_id');
    }

}
