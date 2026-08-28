<?php

namespace App\Enums;

//parce que php7.3 ne supporte pas les Enum...

class ClassStyleEnum
{
    const MATERNELLE = 'maternelle';
    const PRIMAIRE = 'primaire';

    /**
     * Retourne les valeurs des styles sous forme de tableau
     */
    public static function values(): array
    {
        return [
            self::MATERNELLE,
            self::PRIMAIRE,
        ];
    }
}
