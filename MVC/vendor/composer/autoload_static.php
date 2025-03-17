<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticIniteaa06dc34a6e0a411c77f568b2f2b01e
{
    public static $prefixLengthsPsr4 = array (
        'C' => 
        array (
            'Core\\' => 5,
        ),
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Core\\' => 
        array (
            0 => __DIR__ . '/../..' . '/core',
        ),
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'Core\\Autoloader' => __DIR__ . '/../..' . '/core/Autoloader.php',
        'Core\\Controller' => __DIR__ . '/../..' . '/core/Controller.php',
        'Core\\Model' => __DIR__ . '/../..' . '/core/Model.php',
        'Core\\Request' => __DIR__ . '/../..' . '/core/Request.php',
        'Core\\Response' => __DIR__ . '/../..' . '/core/Response.php',
        'Core\\Router' => __DIR__ . '/../..' . '/core/Router.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticIniteaa06dc34a6e0a411c77f568b2f2b01e::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticIniteaa06dc34a6e0a411c77f568b2f2b01e::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticIniteaa06dc34a6e0a411c77f568b2f2b01e::$classMap;

        }, null, ClassLoader::class);
    }
}
