<?php

namespace App\Bootstrap;

use Illuminate\Foundation\Bootstrap\HandleExceptions as BaseHandleExceptions;

/**
 * Surcharge de HandleExceptions pour ignorer les E_DEPRECATED générés
 * par l'incompatibilité PHP 8.1+ / Laravel 8 (return types d'interfaces).
 *
 * En PHP 8.1+, implémenter ArrayAccess, Countable, Iterator, Serializable
 * sans les bons return types génère un E_DEPRECATED. Laravel 8 le convertit
 * en ErrorException fatale via handleError(). Cette classe l'intercepte
 * avant pour ne pas bloquer les tests ni le démarrage de l'application.
 */
class HandleExceptions extends BaseHandleExceptions
{
    public function handleError($level, $message, $file = '', $line = 0, $context = [])
    {
        if ($level === E_DEPRECATED || $level === E_USER_DEPRECATED) {
            return;
        }

        parent::handleError($level, $message, $file, $line, $context);
    }
}
