<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TypeRequete extends Model
{
	use SoftDeletes;

	protected $table = 'type_requetes';

    protected $fillable=[
        'name',
        'created_by',
        'updated_by',
    ];
}
