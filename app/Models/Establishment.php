<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Establishment
 *
 * @property int $id
 * @property string $name
 * @property string $ministry
 * @property string $region
 * @property string $department
 * @property string $phone
 * @property string|null $rib
 * @property string|null $banque
 * @property int|null $om
 * @property int|null $idFounder
 * @property int|null $idPrefetEtude
 * @property int|null $idSecretaire
 * @property string $country
 * @property string $email
 * @property int $idPackage
 * @property string|null $website
 * @property string|null $logo
 * @property string|null $cle
 * @property string|null $route
 * @property string|null $administrative_status
 * @property string|null $religious_status
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Establishment extends Model
{
	use SoftDeletes;

	protected $table = 'establishments';

	public function users(){
		return $this->belongsToMany('App\Models\User','establishments_has_users');
	}

	protected $casts = [
		'idFounder' => 'int',
		'idPrefetEtude' => 'int',
		'idSecretaire' => 'int',
		'idPackage' => 'int',
		'om' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'name',
        'ministry',
        'region',
        'department',
		'phone',
		'mobile_money_number',
		'rib',
		'cnps',
		'banque',
		'om',
		'idFounder',
		'idPrefetEtude',
		'idSecretaire',
		'country',
		'email',
		'idPackage',
		'website',
		'logo',
		'cle',
		'route',
		'administrative_status',
		'religious_status',
		'created_by',
		'updated_by'
	];
}
