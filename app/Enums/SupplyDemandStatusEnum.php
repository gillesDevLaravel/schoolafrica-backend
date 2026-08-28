<?php

namespace App\Enums;

class SupplyDemandStatusEnum
{
    const PENDING = 'pending';
    const ACCEPTED = 'accepted';
    const REFUSED = 'refused';

    public static function values(): array
    {
        return [
            self::PENDING,
            self::ACCEPTED,
            self::REFUSED,
        ];
    }
}
