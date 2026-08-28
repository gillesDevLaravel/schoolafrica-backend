<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table = 'logs';

    protected $fillable = [
        'idUser',
        'idStudent',
        'description',
    ];

    public static function critical(string $string)
    {
    }

    public static function error(string $string)
    {
    }

    public static function info(string $string, array $array)
    {
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'idUser');
    }
    public function student()
    {
        return $this->belongsTo(User::class, 'idStudent');
    }
}
