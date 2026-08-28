<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Google\Service\Classroom;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class School
 *
 * @property int $id
 * @property string $name
 * @property string $adresse
 * @property string $phone
 * @property string $city
 * @property string $section
 * @property int|null $idPrincipal
 * @property int|null $idAssistant
 * @property int $idEstablishment
 * @property string $scholar_level
 * @property string|null $email
 * @property string|null $website
 * @property string|null $logo
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class School extends Model
{
	use SoftDeletes;

	protected $table = 'schools';

	protected $casts = [
		'idPrincipal' => 'int',
		'idAssistant' => 'int',
		'idEstablishment' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'name',
		'adresse',
		'phone',
		'city',
		'section',
		'idPrincipal',
		'idAdjoint',
		'idAssistant',
		'secretary_id',
		'idEstablishment',
		'scholar_level',
		'email',
		'website',
		'logo',
		'matricule_code',
		'land_title',
		'building_permit',
		'creation_authorization',
		'opening_authorization',
		'nui',
		'cnps',
		'location_plan',
		'information_sheets',
		'created_by',
		'updated_by'
	];

	public function establishment()
    {
        return $this->belongsTo(Establishment::class, 'idEstablishment');
    }

    public function sections()
    {
        return $this->hasMany(Section::class, 'idSchool');
    }

    public function classes()
    {
        return $this->hasMany(Classes::class, 'idSchool');
    }

    public function principal()
    {
        return $this->belongsTo(User::class, 'idPrincipal');
    }
    public function adjoint()
    {
        return $this->belongsTo(User::class, 'idAdjoint');
    }

    public function assistant()
    {
        return $this->belongsTo(User::class, 'idAssistant');
    }

    public function secretary()
    {
        return $this->belongsTo(User::class, 'secretary_id');
    }
}
