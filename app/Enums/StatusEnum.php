<?php

namespace App\Enums;

//parce que php7.3 ne supporte pas les Enum...

class StatusEnum
{
    const PENDING_APPROVAL = 'pending_approval';
    const IN_PROGRESS = 'in_progress';
    const APPROVED = 'approved';
    const REJECTED = 'rejected';

    /**
     * Retourne les valeurs des statuts sous forme de tableau
     */
    public static function values(): array
    {
        return [
            self::PENDING_APPROVAL,
            self::IN_PROGRESS,
            self::APPROVED,
            self::REJECTED,
        ];
    }
}
