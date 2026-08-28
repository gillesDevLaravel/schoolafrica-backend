<?php

namespace App\Enums;

class NoteFraiStatusEnum
{
    const APPROVE = 'approve';
    const IN_PROGRESS = 'in_progress';
    const REJECTED = 'rejected';

    public static function values(): array
    {
        return [
            self::APPROVE,
            self::IN_PROGRESS,
            self::REJECTED,
        ];
    }
}
