<?php

namespace App\Models;

use App\Traits\SMSTrait;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Notification;
use App\Models\Sms;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class Withdrawal extends Model
{
    use SMSTrait;

    protected $table = 'withdrawals';

    protected $casts = [
        'code' => 'double',
        'date' => 'datetime',
        'idUser' => 'int',
        'idSchool' => 'int',
        'idSection' => 'int',
        'montant_retrait_brut' => 'double',
        'montant_retrait_net' => 'double',
        'frais_bancaire' => 'double',
        'numero_retrait' => 'int',
        'created_by' => 'int',
        'updated_by' => 'int'
    ];

    protected $fillable = [
        'type',
        'montant_retrait_brut',
        'montant_retrait_net',
        'frais_bancaire',
        'mode_retrait',
        'status',
        'code',
        'rib',
        'idUser',
        'numero_retrait',
        'date',
        'reference',
        'details',
        'idSchool',
        'idSection',
        'created_by',
        'updated_by'
    ];

    protected static function booted()
    {
        static::updated(function ($withdrawal) {
            if ($withdrawal->isDirty('status') && $withdrawal->status === 'success') {
                try {
                    // Récupérer l'utilisateur avec les infos nécessaires
                    $user = User::find($withdrawal->idUser, ['id', 'phone', 'phone_2', 'idSchool', 'idSection']);
                    if (!$user) return;

                    $message = __('withdrawal.notif_description', ['amount' => $withdrawal->montant_retrait_net]);

                    // Notification
                    Notification::create([
                        'notificationable_type' => Withdrawal::class,
                        'notificationable_id' => $withdrawal->id,
                        'title' => __('withdrawal.notif_title'),
                        'description' => $message,
                        'user_id' => $user->id,
                    ]);

                    // Envoi SMS et enregistrement en base
                    $phones = array_filter([$user->phone, $user->phone_2]);
                    if ($phones) {
                        $smsResponse = $withdrawal->sendSMS($phones, $message);

                        Sms::insert([[
                            'uuid' => Str::uuid(),
                            'idUsers' => $user->id,
                            'message' => $message,
                            'status' => $smsResponse['responsecode'] ? 'success' : 'failed',
                            'created_at' => now(),
                            'updated_at' => now(),
                            'created_by' => $withdrawal->created_by ?: $user->id,
                            'idSchool' => $user->idSchool,
                            'idSection' => $user->idSection,
                        ]]);

                        if (!$smsResponse['responsecode']) {
                            Log::warning("SMS retrait failed for user {$user->id}: ".$smsResponse['responsedescription']);
                        }
                    }

                } catch (\Throwable $th) {
                    Log::error("Erreur notification/SMS Withdrawal {$withdrawal->id}: {$th->getMessage()}");
                }
            }
        });
    }
}
