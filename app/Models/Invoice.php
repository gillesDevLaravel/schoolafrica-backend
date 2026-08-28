<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Invoice
 *
 * @property int $id
 * @property float $amount
 * @property string $reasons
 * @property Carbon $payment_deadline
 * @property int $idSchool
 * @property int|null $idSection
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Invoice extends Model
{
    use SoftDeletes;
    
    protected $table = 'invoices';

	protected $casts = [
		'amount' => 'float',
		'purchase_order_id' => 'int',
		'idSchool' => 'int',
		'idSection' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $dates = [
		'payment_deadline',
		'deleted_at'
	];

	protected $fillable = [
		'amount',
		'purchase_order_id',
		'reasons',
		'payment_deadline',
		'idSchool',
		'idSection',
		'created_by',
		'updated_by',
		'idCustomer',
		'idUser',
		'idTypeInvoice',
		'idProduct',
		'invoiceable_type',
		'invoiceable_id',
		'image',
		'date',
		'statut',
		'mode',
		'number',
		'type_produit',
		'quantite',
		'prix_unitaire',
	];

//    public function getImageAttribute()
//    {
//        return !is_null($this->attributes['image']) ? asset("public/invoices/" . $this->attributes['image']) : null;
//    }

    public function type_invoice()
    {
        return $this->belongsTo(TypeInvoice::class, 'idTypeInvoice');
    }

    public function invoiceable()
    {
        return $this->morphTo();
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'idProduct');
    }
	 
	public function school()
	{
		return $this->belongsTo(School::class, 'idSchool');
	}

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class, 'purchase_order_id');
    }

    /**
     * Relation many-to-many avec les salary components via la table pivot
     */
    public function salaryComponents(): BelongsToMany
    {
        return $this->belongsToMany(SalaryComponent::class, 'invoice_salary_component', 'invoice_id', 'salary_component_id')
            ->withPivot('coef', 'base_amount', 'coef_patronal', 'base_patronal');
    }

    /**
     * Calcule le montant total pour un composant de salaire (coef * base_amount)
     */
    public function getTotalAmountSalaryAttribute()
    {
        return $this->salaryComponents->sum(function ($salaryComponent) {
            /** @var SalaryComponent $salaryComponent */
           
            return $salaryComponent->pivot->coef * $salaryComponent->pivot->base_amount;
        });
    }
	/**
     * Calcule le montant patronal pour un composant de salaire (coef_patronal * base_patronal)
     */
	public function getTotalAmountPatronalAttribute()
	{
		return $this->salaryComponents->sum(function ($salaryComponent) {
			/** @var SalaryComponent $salaryComponent */
			
			return $salaryComponent->pivot->coef_patronal * $salaryComponent->pivot->base_patronal;
		});
	}

}