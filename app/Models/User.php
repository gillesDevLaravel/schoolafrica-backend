<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Traits\MailTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

/**
 * Class User
 *
 * @property int $id
 * @property string $name
 * @property string|null $firstname
 * @property string|null $placeofbirth
 * @property string|null $situation
 * @property bool|null $repeater
 * @property string|null $email
 * @property Carbon|null $email_verified_at
 * @property string|null $password
 * @property string|null $username
 * @property string|null $phone
 * @property string|null $adresse
 * @property string $gender
 * @property string|null $country
 * @property string|null $city
 * @property bool|null $fit
 * @property string|null $desease
 * @property string|null $matricule
 * @property string|null $photo
 * @property string|null $profession
 * @property string|null $bank_name
 * @property string|null $bank_rib
// * @property int|null $number_days_off
 * @property Carbon|null $birthday
 * @property string|null $device_key
 * @property string|null $cni
 * @property string|null $nationality
 * @property string|null $codeun
 * @property string|null $codedeux
 * @property int|null $salary
 * @property int|null $hourlyPrice
 * @property int|null $idMatter
 * @property int|null $idParent
 * @property int|null $idLevel
 * @property int|null $idOptionLevel
 * @property int|null $idSchool
 * @property int|null $idSection
 * @property int|null $idCycle
 * @property int|null $idClasse
 * @property int|null idClasse2
 * @property bool $deleted
 * @property string|null $remember_token
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class User extends Authenticatable
{
    use HasApiTokens, HasRoles, Notifiable, MailTrait;
	//use  HasFactory;

	protected $table = 'users';
	protected $guard_name = 'web';

	public function matters(){
		return $this->belongsToMany('App\Models\Matter','matter_has_user');
	}

	public function classes(){
		return $this->belongsToMany('App\Models\Classes','classe_has_user');
	}

	public function classe()
    {
        return $this->belongsTo(Classes::class, 'idClasse');
    }

	public function optionLevel()
    {
        return $this->belongsTo(OptionLevel::class, 'idOptionLevel');
    }

    public function parent()
    {
        return $this->belongsTo(User::class, 'idParent');
    }

	protected $casts = [
		'repeater' => 'bool',
		'email_verified_at' => 'datetime',
		'fit' => 'bool',
		'birthday' => 'datetime',
		'hiring_date' => 'datetime',
		'salary' => 'int',
		'hourlyPrice' => 'int',
		'idMatter' => 'int',
		'idParent' => 'int',
		'idLevel' => 'int',
		'idOptionLevel' => 'int',
		'idSchool' => 'int',
		'idSection' => 'int',
		'idCycle' => 'int',
		'idClasse' => 'int',
		'idClassePrincipal' => 'int',
		'deleted' => 'bool',
		'created_by' => 'int',
		'updated_by' => 'int',
//		'number_days_off' => 'int',
	];

	protected $hidden = [
		'password',
		'remember_token'
	];

	protected $fillable = [
		'name',
		'firstname',
		'placeofbirth',
		'situation',
		'repeater',
		'email',
		'whatsapp_number',
		'email_verified_at',
		'password',
		'username',
		'phone',
		'adresse',
		'mother',
		'tutor',
		'phone_2',
		'phone_3',
		'phone_4',
		'phone_5',
		'phone_6',
		'observation',
		'gender',
		'adresse_2',
		'adresse_tutor',
		'gender_2',
		'gender_tutor',
		'country',
		'city',
		'fit',
		'desease',
		'matricule',
		'cat',
		'ech',
		'photo',
		'profession',
		'bank_name',
		'bank_rib',
//		'number_days_off',
		'birthday',
		'hiring_date',
		'device_key',
		'cni',
		'nationality',
		'codeun',
		'codedeux',
		'salary',
		'hourlyPrice',
		'grade',
		'anciennete',
		'idMatter',
		'idParent',
		'idLevel',
		'idOptionLevel',
		'idSchool',
		'idSection',
		'idCycle',
		'idClasse',
		'idClasse2',
		'old_classe',
		'idClassePrincipal',
		'idBourse',
		'isBourseUsed',
        'annualDecision',
        'num_cnps',
        'niu',
        'agence',
        'service',
        'categorie',
        'num_dipe',
        'date_embauche',
		'deleted',
		'remember_token',
		'created_by',
		'updated_by',
		'deleted_by',
	];

    //TODO: On prend toujours idLevel qui est sur la table Classe
    public function getIdLevelAttribute()
    {
        return @$this->classe->idLevel;
    }

    public function setIdClasseAttribute($idClasse)
    {
        $this->attributes['idClasse'] = $idClasse;
        $this->attributes['idLevel'] = @$this->classe->idLevel; // quand on modifie la classe, modifie aussi le level
    }

    public static function generateUser($property, $length = 8)
    {
        do{
            $code = "";

            $chaine = "0192837465APZOEIRUTYQMSLDKFJGHWNXBCV";

            srand((double)microtime() * 1000000);

            for ($i=0; $i<$length; $i++){
                $code .= $chaine[rand()%strlen($chaine)];
            }

        }while(User::where($property, $code)->first());

        return $code;
    }

    public static function generateMatricule($p1, $p2, $p3)
    {
        $users = User::join('model_has_roles','users.id','=','model_has_roles.model_id')
            ->join('roles','model_has_roles.role_id','=','roles.id')
            ->join('schools','schools.id','=','users.idSchool')
            ->join('classes', 'classes.id', "=", "users.idClasse")
            ->where('roles.id', 8)
            ->where('users.deleted',0)
            ->count(); // on compte le nombre d'utilisateurs déjà inscrits pour mettre le suivant

        do{
            $users++;

            $position_user = str_pad($users, 4, "0", STR_PAD_LEFT);

            $matricule = strtoupper($p1.$p2.$p3.$position_user); // GSBJANG20240001 par exemple

        }while(User::where("matricule", $matricule)->first());

        return $matricule;
    }

    public function splitDeviceKey()
    {
        return explode(";;;", $this->device_key);
    }

    public function projects(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Project::class);
    }

    protected static function booted(){
        static::addGlobalScope('isDeleted', function(Builder $builder){
            if (!app()->runningInConsole()) { // Ou tout autre mécanisme pour conditionner
                $builder->where('users.deleted', false);
            }
        });
    }

    public function getRole(){
        $idUser = $this->id;

        $role = User::select('roles.id','roles.name','roles.type')
            ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->where('users.id', $idUser)->first();


        return $role;
    }

    public function bonuses()
    {
        return $this->hasMany(Bonus::class, "idUser");
    }

    public function school()
    {
        return $this->belongsTo(School::class, "idSchool");
    }// app/Models/User.php

    public function annualDecisions()
    {
        return $this->hasMany(AnnualDecision::class, 'idUser');
    }

    public function getDecisionForOptionLevel($idOptionLevel = null)
    {
        // Récupérer la décision annuelle correspondante
        $decisionAnnuelle = $idOptionLevel === null
            ? $this->annualDecision
            : $this->annualDecisions()
            ->where('idOptionLevel', $idOptionLevel)
            ->first();

        if (!$decisionAnnuelle) {
            return null; // Ou une valeur par défaut, ex: 'Aucune décision'
        }

        if (isset($decisionAnnuelle->decision)){
            $key = "bulletin." . $decisionAnnuelle->decision;
        }
        else{
            $key = "bulletin." . $decisionAnnuelle;

        }

        $translated = __($key);

        return $translated !== $key ? $translated : $decisionAnnuelle->decision ?? $decisionAnnuelle;
    }

    public function scopeStudents($query)
    {
        return $query->whereHas('roles', function ($q) {
            $q->where('id', 8); // rôle 'student'
        });
    }

    /**
     * Relation pratique pour accéder uniquement aux étudiants.
     */
    public static function students()
    {
        return static::whereHas('roles', function ($q) {
            $q->where('id', 8);
        });
    }
    public function getAncienneteAttribute()
    {
        return Carbon::now()->diffInYears($this->hiring_date);
    }

}
