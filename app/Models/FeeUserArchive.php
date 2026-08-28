<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class FeeUser
 *
 * @property int $id
 * @property int $idTransaction
 * @property int $idStudent
 * @property int $idSchool
 * @property int $idSection
 * @property int $idFee
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
class FeeUserArchive extends Model
{
	protected $table = 'fee_user_archives';

	protected $casts = [
		'idStudent' => 'int',
		'idSchool' => 'int',
		'idSection' => 'int',
		'idFee' => 'int',
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
		'idFee',
		'scanReceipt',
		'advancePayment',
		'balancePayment',
		'payment_mode',
		'solvable',
//		'photo',
		'reason',
		'deleted',
		'deleted_by',
		'receiptNumber',
		'operator',
		'paymentDate',
		'created_by',
		'updated_by',
		'telephone',
		'reference'
	];

    protected static function booted(){
        static::addGlobalScope('isDeleted', function(Builder $builder){
            $builder->where('fee_user_archives.deleted', false);
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

	public function fee()
    {
        return $this->belongsTo(Fee::class, 'idFee');
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
//        return (!is_null($this->attributes['photo'])) ? asset("public/feeUsers/" . $this->attributes['photo']) : null;
//    }
}
