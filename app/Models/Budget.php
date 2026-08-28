<?php

namespace App\Models;

use App\Enums\BudgetTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Budget extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'type',
        'description',
        'realisation',
        'school_id',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'realisation' => 'float',
    ];


    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class, 'school_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function typeInvoices(): BelongsToMany
    {
        return $this->belongsToMany(TypeInvoice::class, 'budget_type_invoice')
            ->withPivot(['quantity', 'number', 'amount']);
    }

    public function typeOfRecipes(): BelongsToMany
    {
        return $this->belongsToMany(TypeOfRecipe::class, 'budget_type_of_recipe')
            ->withPivot(['quantity', 'number', 'amount']);
    }

    /**
     * Retourne les éléments liés dynamiquement selon le type de budget
     * avec ajout du champ sub_total_amount
     */
    public function typeInvoiceOrRecipeItems(): \Illuminate\Support\Collection
    {
        $items = $this->type === BudgetTypeEnum::RECIPE
            ? $this->typeOfRecipes()->get()
            : $this->typeInvoices()->get();

        // Ajouter sous_total_amount à chaque élément
        return $items->map(function ($item) {
            $pivot = $item->pivot;
            $item->sub_total_amount = $pivot->amount * $pivot->number * $pivot->quantity;
            return $item;
        });
    }

    public function getRecipeOrInvoiceItemByTypeId($typeId)
    {
        if ($this->type === BudgetTypeEnum::RECIPE) {
            $relation = $this->typeOfRecipes()->where('type_of_recipes.id', $typeId);
        } else {
            $relation = $this->typeInvoices()->where('type_invoices.id', $typeId);
        }

        $item = $relation->first();

        if ($item && $item->pivot) {
            $pivot = $item->pivot;
            $item->sub_total_amount = $pivot->amount * $pivot->number * $pivot->quantity;
        }

        return $item;
    }



    /**
     * Attribut dynamique : somme de tous les sous-totaux
     */
    public function getTotalAmountAttribute(): float
    {
        return $this->typeInvoiceOrRecipeItems()
            ->sum(function ($item) {
                return $item->sub_total_amount;
            });
    }
}
