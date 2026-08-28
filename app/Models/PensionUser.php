<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PensionUser
 *
 * @property int $id
 * @property int $idTransaction
 * @property int $idStudent
 * @property int $idSchool
 * @property int $idSection
 * @property int $idPension
 * @property int $idTranche
 * @property int $idScanReceipt
 * @property float $advancePayment
 * @property float $balancePayment
 * @property string $payment_mode
 * @property string $solvable
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class PensionUser extends Model
{
	protected $table = 'pension_users';

	protected $casts = [
		'idStudent' => 'int',
		'idSchool' => 'int',
		'idSection' => 'int',
		'idPension' => 'int',
		'idTranche' => 'int',
		'advancePayment' => 'float',
		'balancePayment' => 'float',
		'created_by' => 'int',
		'updated_by' => 'int',
		'telephone' => 'string',
		'reference' => 'string',
	];

	protected $fillable = [
		'idTransaction',
		'idStudent',
		'idSchool',
		'idSection',
		'idPension',
		'idTranche',
		'scanReceipt',
		'advancePayment',
		'balancePayment',
		'payment_mode',
		'solvable',
		'photo',
		'idBourse',
		'reason',
		'deleted',
		'deleted_by',
		'receiptNumber',
		'operator',
		'paymentDate',
		'created_by',
		'updated_by',
		'telephone',
		'reference',
	];

    public function getRemainingPensionAttribute(): ?float
    {
        // Sécurité : si le paiement n'est pas encore persisté
        if (is_null($this->created_at)) {
            return $this->tranche ? (float) $this->tranche->price : null;
        }

        // 1. Paiement précédent (même tranche)
        $previousPayment = self::where('idStudent', $this->idStudent)
            ->where('idPension', $this->idPension)
            ->where('idTranche', $this->idTranche)
            ->where('created_at', '<', $this->created_at)
            ->orderByDesc('created_at')
            ->first();

        // 2. Si trouvé → remaining = balance précédent
        if ($previousPayment) {
            return (float) $previousPayment->balancePayment;
        }

        // 3. Sinon → montant initial de la tranche
        return $this->tranche
            ? (float) $this->tranche->price
            : null;
    }


    protected static function booted(){

        //Je veux que, par défaut, toutes les requêtes prennent les résultats qui ne sont pas 'deleted'
        static::addGlobalScope('isDeleted', function(Builder $builder){
            $builder->where('pension_users.deleted', false);
        });
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'idStudent');
    }

    public function school()
    {
        return $this->belongsTo(School::class, 'idSchool');
    }

    public function tranche()
    {
        return $this->belongsTo(Tranche::class, 'idTranche');
    }

	public function pension()
    {
        return $this->belongsTo(Pension::class, 'idPension');
    }
	public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'idTransaction');
    }

//    public function scanReceipt()
//    {
//        return $this->belongsTo(ScanReceipt::class, 'idScanReceipt');
//    }

//    public function getPhotoAttribute()
//    {
//        return (!is_null($this->attributes['photo'])) ? asset("public/pensionUsers/" . $this->attributes['photo']) : null;
//    }
}
