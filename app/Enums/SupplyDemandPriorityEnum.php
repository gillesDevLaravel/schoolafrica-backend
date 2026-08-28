<?php

namespace App\Enums;

class SupplyDemandPriorityEnum
{
    const HIGH = 'high';
    const MEDIUM = 'medium';
    const LOW = 'low';

    public static function values(): array
    {
        return [
            self::HIGH,
            self::MEDIUM,
            self::LOW,
        ];
    }
}
