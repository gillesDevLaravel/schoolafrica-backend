<?php

namespace App\Enums;

class PurchaseOrderPaymentMethodEnum
{
    const CASH = 'Cash';
    const BANK = 'Bank';
    const OM = 'OM';
    const MOMO = 'MOMO';

    public static function values(): array
    {
        return [
            self::CASH,
            self::BANK,
            self::OM,
            self::MOMO,
        ];
    }
}
