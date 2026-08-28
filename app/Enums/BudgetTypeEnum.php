<?php

namespace App\Enums;

class BudgetTypeEnum
{
    // Dans App\Models\Booking.php

    const INVOICE = 'Invoice';

    const RECIPE = 'Recipe';

    public static function values(): array
    {
        return [
            self::INVOICE,
            self::RECIPE,
        ];
    }
}
