<?php

namespace App\Enums;

class ArticleMovementOperationTypeEnum
{
    // Dans App\Models\Booking.php

    const ENTRY = 'entry';

    const EXIT = 'exit';

    const RENTAL_ENTRY = 'rental_entry';
    const RENTAL_EXIT = 'rental_exit';

    public static function values(): array
    {
        return [
            self::ENTRY,
            self::EXIT,
            self::RENTAL_ENTRY,
            self::RENTAL_EXIT,
        ];
    }
}
