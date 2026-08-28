<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MobileBuildVersion extends Model
{
    protected $table = 'mobile_build_versions';

    protected $connection = 'mysql2';

    protected $fillable=[
        'build_number',
        'verified',
    ];
}
