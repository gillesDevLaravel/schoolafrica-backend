<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sms extends Model
{
    protected $table = 'sms';

    protected $fillable = [
        'uuid',
        'idUsers',
        'message',
        'status',
        'idSchool',
        'idSection',
        'created_by',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function school()
    {
        return $this->belongsTo(School::class, 'idSchool', 'id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'idSection', 'id');
    }
}
