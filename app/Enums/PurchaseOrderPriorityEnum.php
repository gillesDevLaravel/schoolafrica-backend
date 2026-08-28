<?php

namespace App\Enums;

class PurchaseOrderPriorityEnum
{
    const LOW = 'low';         // Faible priorité

    const MEDIUM = 'medium';   // Priorité moyenne

    const HIGH = 'high';       // Haute priorité

    public static function values(): array
    {
        return [
            self::LOW,
            self::MEDIUM,
            self::HIGH,
        ];
    }
}
