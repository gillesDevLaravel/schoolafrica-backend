<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rental extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'article_id',
        'reason',
        'description',
        'exit_quantity',
        'entry_quantity',
        'exit_date',
        'entry_date',
        'exit_condition',
        'entry_condition',
        'exit_image',
        'entry_image',
        'total_price',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
    public function article(){
        return $this->belongsTo(Article::class, 'article_id');
    }
    public function createdBy(){
        return $this->belongsTo(User::class, 'created_by');
    }
    public function updatedBy(){
        return $this->belongsTo(User::class, 'updated_by');
    }
}
