<?php

namespace App\Enums;

class ArticleTypeEnum
{
    // Dans App\Models\Booking.php

    const CONSUMABLE = 'consumable';

    const STORABLE = 'storable';

    public static function values(): array
    {
        return [
            self::CONSUMABLE,
            self::STORABLE,
        ];
    }
}
