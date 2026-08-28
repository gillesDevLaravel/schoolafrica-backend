<?php

namespace App\Enums;

class PurchaseOrderStatusEnum
{
    const REQUESTING_PRICE = 'requesting_price'; // on attend que le fournisseur nous envoie les prix
    const PURCHASE_ORDER = 'purchase_order'; // on a reçu les prix et voilà ...
    const PAID = 'paid';
    const DELIVERED = 'delivered';

    public static function values(): array
    {
        return [
            self::REQUESTING_PRICE,
            self::PURCHASE_ORDER,
            self::PAID,
            self::DELIVERED,
        ];
    }
}
