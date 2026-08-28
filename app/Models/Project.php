<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'name', 'description', 'start_date', 'end_date', 'deleted', 'created_by', 'updated_by'
    ];

    protected static function booted(){
        static::addGlobalScope('isDeleted', function(Builder $builder){
            $builder->where('projects.deleted', false);
        });
    }

    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'project_user', 'project_id', 'user_id');
    }
}
