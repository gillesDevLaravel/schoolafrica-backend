<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CertificatTransfert extends Model
{
    protected $table = 'certificat_transferts';

    protected $fillable = [
        'idStudent',
        'reason',
        'to',
        'academic_year',
        'on',
        'created_by',
    ];
}
