<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalaryComponent extends Model
{
    use SoftDeletes;

    protected $table = 'salary_components';

    protected $fillable = [
        'name',
        'code',
        'type',
        'base_amount',
        'coef',
        'coef_patronal',
        'base_patronal',
        'order',
        'created_by',
        'updated_by',
        'deleted',
        'deleted_by',
    ];

    protected $casts = [
        'base_amount' => 'float',
        'coef' => 'float',
        'coef_patronal' => 'float',
        'base_patronal' => 'float',
        'order' => 'integer',
        'deleted' => 'bool',
    ];

    /**
     * Relation many-to-many avec les invoices via la table pivot
     */
    public function invoices(): BelongsToMany
    {
        return $this->belongsToMany(Invoice::class, 'invoice_salary_component', 'salary_component_id', 'invoice_id')
            ->withPivot('coef', 'base_amount', 'coef_patronal', 'base_patronal');
    }
}
