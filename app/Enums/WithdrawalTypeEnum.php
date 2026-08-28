<?php

namespace App\Enums;

//parce que php7.3 ne supporte pas les Enum...

class WithdrawalTypeEnum
{
    const OM = 'Orange Money';
    const MOMO = 'Mobile Money';

    /**
     * Retourne les valeurs des statuts sous forme de tableau
     */
    public static function values(): array
    {
        return [
            self::OM,
            self::MOMO,
        ];
    }
}
