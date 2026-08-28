<?php

/**
 * PHPUnit bootstrap custom pour PHP 8.3 + Laravel 8.
 *
 * Laravel 8 génère des E_DEPRECATED sur les return types d'interface
 * (ArrayAccess, Countable, Iterator…) qui ne sont pas reconnus par PHP 8.1+.
 * HandleExceptions::bootstrap() appelle error_reporting(-1) puis convertit
 * tout E_DEPRECATED en ErrorException fatale.
 *
 * Fix : on force le chargement des classes problématiques AVANT que
 * HandleExceptions ne s'installe, pendant la fenêtre où error_reporting
 * ne transforme pas encore les deprecations en exceptions.
 */

// 1. Supprimer les E_DEPRECATED le temps du chargement de l'autoloader
error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);

require __DIR__ . '/../vendor/autoload.php';

// 2. Pré-charger les classes Laravel 8 qui déclenchent un E_DEPRECATED
//    lors de leur première inclusion (héritage / implémentation d'interface
//    sans return type PHP 8.1+). Elles seront déjà en mémoire quand
//    HandleExceptions sera installé et appellera error_reporting(-1).
$preload = [
    // Support
    \Illuminate\Support\Collection::class,
    \Illuminate\Support\LazyCollection::class,
    \Illuminate\Support\Str::class,
    \Illuminate\Support\Fluent::class,
    // Container / Config
    \Illuminate\Container\Container::class,
    \Illuminate\Config\Repository::class,
    // Eloquent
    \Illuminate\Database\Eloquent\Model::class,
    \Illuminate\Database\Eloquent\Collection::class,
    \Illuminate\Database\Eloquent\Builder::class,
    \Illuminate\Database\Query\Builder::class,
    // HTTP / Routing
    \Illuminate\Http\Request::class,
    \Illuminate\Routing\Router::class,
    \Illuminate\Routing\RouteCollection::class,
    \Illuminate\Routing\Route::class,
    // Session / Cookie
    \Illuminate\Session\Store::class,
    \Illuminate\Cookie\CookieJar::class,
    // Cache
    \Illuminate\Cache\Repository::class,
];

foreach ($preload as $class) {
    if (class_exists($class, true)) {
        // class_exists avec $autoload=true déclenche le chargement
    }
}

// 3. Restaurer le reporting normal (warnings, notices, errors — sans deprecated)
//    HandleExceptions le remettra à -1, mais les classes sont déjà en mémoire.
error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);
