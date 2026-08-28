<?php

namespace App\Enums;

class PurchaseOrderPaymentStatusEnum
{
    const NONE = 'none';         // No payment
    const ADVANCE = 'advance';   // Partial payment
    const COMPLETED = 'completed'; // Fully paid

    public static function values(): array
    {
        return [
            self::NONE,
            self::ADVANCE,
            self::COMPLETED,
        ];
    }
}



