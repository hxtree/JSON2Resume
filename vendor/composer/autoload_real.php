<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit03e56484cb89f9309cbeaf21ef25e44b
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        spl_autoload_register(array('ComposerAutoloaderInit03e56484cb89f9309cbeaf21ef25e44b', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit03e56484cb89f9309cbeaf21ef25e44b', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit03e56484cb89f9309cbeaf21ef25e44b::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
