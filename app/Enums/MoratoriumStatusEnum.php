<?php

namespace App\Enums;

//parce que php7.3 ne supporte pas les Enum...

class MoratoriumStatusEnum
{
    const PENDING_APPROVAL = 'pending_approval';
    const VALID = 'valid';
    const EXPIRED = 'expired';
    const APPROVED = 'approved';
    const REJECTED = 'rejected';

    /**
     * Retourne les valeurs des statuts sous forme de tableau
     */
    public static function values(): array
    {
        return [
            self::PENDING_APPROVAL,
            self::EXPIRED,
            self::APPROVED,
            self::REJECTED,
        ];
    }
}
