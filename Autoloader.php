<?php

/**
* Classe permetant d'autoloader les classes.
* @author Bastien Vacherand.
*/

namespace Bastien\blog;

class Autoloader
{
    public static function register()
    {
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }

    public static function autoload($class)
    {
        $class = str_replace(__NAMESPACE__ . '\\', '', $class);
        $class = str_replace('\\', '/', $class);
        require $class . '.php';
    }
}
