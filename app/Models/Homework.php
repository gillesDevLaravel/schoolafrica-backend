<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Homework
 *
 * @property int $id
 * @property string $name
 * @property Carbon $deadline
 * @property string|null $description
 * @property string|null $answer
 * @property string|null $status
 * @property int $idClasse
 * @property int $idMatter
 * @property int|null $idTeacher
 * @property int $idSchool
 * @property int $idSection
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Homework extends Model
{
    protected $table = 'homework';

    protected $casts = [
        'idClasse' => 'int',
        'idMatter' => 'int',
        'idTeacher' => 'int',
        'idSchool' => 'int',
        'idSection' => 'int',
        'created_by' => 'int',
        'updated_by' => 'int'
    ];

    protected $dates = [
        'deadline'
    ];

    protected $fillable = [
        'name',
        'deadline',
        'description',
        'answer',
        'status',
        'idClasse',
        'idMatter',
        'idTeacher',
        'idBook',
        'idSchool',
        'idSection',
        'created_by',
        'updated_by',
        'deleted',
        'deleted_by',
    ];

    public function notifications()
    {
        return $this->morphMany(Notification::class, 'notificationable');
    }

    protected static function booted(){
        //Je veux que, par défaut, toutes les requêtes prennent les résultats qui ne sont pas 'deleted'
        static::addGlobalScope('isDeleted', function(Builder $builder){
            $builder->where('homework.deleted', false);
        });
    }

    public function book()
    {
        return $this->belongsTo(Book::class, 'idBook');
    }
}
