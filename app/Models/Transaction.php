<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Reliese\Coders\Model\Relations\BelongsTo;

/**
 * Class Transaction
 *
 * @property int $id
 * @property string $access_token
 * @property bigInteger $expires_in
 * @property string|null $order_id
 * @property double|null $amount
 * @property string|null $reference
 * @property string|null $status
 * @property string|null $message
 * @property string|null $pay_token
 * @property string|null $payment_url
 * @property string|null $notif_token
 * @property string|null $tnxid
 * @property string|null $payment_mode
 * @property Carbon|null $payment_date
 * @property int|null $idInvoice
 * @property int|null $idFee
 * @property int|null $idLevel
 * @property int|null $idStudent
 * @property int|null $idSchool
 * @property int|null $idSection
 * @property int|null $idInscription
 * @property int|null $idPension
 * @property int|null $idTranche
 * @property int|null $idEnseignant
 * @property int|null $compteEmeteur
 * @property int|null $compteRecepteur
 * @property string|null $type
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Transaction extends Model
{
	protected $table = 'transactions';

	protected $casts = [
		'payment_date' => 'datetime',
		'idInvoice' => 'int',
		'idSchool' => 'int',
		'idSection' => 'int',
		'idFee' => 'int',
		'idLevel' => 'int',
		'idStudent' => 'int',
		'idInscription' => 'int',
		'idPension' => 'int',
		'idTranche' => 'int',
		'idEnseignant' => 'int',
		'compteEmeteur' => 'int',
		'compteRecepteur' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
        'access_token',
        'expires_in',
        'order_id',
        'amount',
        'reference',
        'status',
        'message',
        'pay_token',
        'payment_url',
        'notif_token',
        'payment_mode',
        'payment_date',
		'idFee',
		'idLevel',
		'idStudent',
        'idInvoice',
        'idSchool',
        'idSection',
        'idInscription',
        'idPension',
        'transport_user_id',
        'idTranche',
        'idEnseignant',
        'compteEmeteur',
        'compteRecepteur',
        'type',
        'deleted',
        'deleted_by',
        'tnxid',
        'created_by',
        'updated_by'
    ];

    protected static function booted(){
        static::addGlobalScope('isDeleted', function(Builder $builder){
            $builder->where('transactions.deleted', false);
        });
    }

    public function student(){
        return $this->BelongsTo(User::class, 'idStudent');
    }
}
